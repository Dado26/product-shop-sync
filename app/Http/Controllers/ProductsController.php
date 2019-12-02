<?php

namespace App\Http\Controllers;

use Queue;
use App\Models\Site;
use App\Models\Product;
use App\Jobs\ProductSyncJob;
use App\Models\ShopCategory;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Helpers\SiteUrlParser;
use App\Jobs\ProductImportJob;
use App\Http\Requests\ProductImportRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $site     = $request->site;

        $searchWords = explode(' ', $search);

        $categories = ShopCategory::allWithFormattedNames();

        $sites = Site::query()->get();

        $products = Product::query()->with(['site', 'variants']);

        if (!empty($search)) {
            $products->where(function ($query) use ($searchWords) {
                foreach ($searchWords as $searchWord) {
                    $query->orWhere('title', 'LIKE', "%$searchWord%")
                          ->orWhere('id', 'LIKE', "%$searchWord%");
                }
            });
        }
        if (!empty($site)) {
            $products->where('site_id', $site);
        }

        $products = $products->latest()->paginate(15);

        return view('products.index', compact('products', 'categories', 'sites'));
    }

    /**
     * @param \App\Http\Requests\ProductImportRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import(ProductImportRequest $request)
    {
        if ($request->batch) {
            $urls = SiteUrlParser::splitUrlsByNewLine($request->urls);

            $jobs = collect($urls)->map(function ($url) use ($request) {
                return new ProductImportJob($url, $request->category);
            })->toArray();

            Queue::bulk($jobs, null, ProductImportJob::QUEUE_NAME);

            flash('Your products were queued successfully, they will be processed soon.')->success();
        } else {
            ProductImportJob::dispatch($request->url, $request->category)->onQueue(ProductImportJob::QUEUE_NAME);

            flash('Your product was queued successfully, it will be processed soon.')->success();
        }

        return redirect()->back();
    }

    /**
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sync(Product $product)
    {
        try {
            ProductSyncJob::dispatchNow($product);

            flash('Your product was synchronized')->success();

            return redirect()->back();
        } catch (InvalidArgumentException $e) {
            logger()->notice('Failed to find required product data, maybe it was removed');
        }

        return redirect()->back();
    }

    /**
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        $variants = $product->variants()->get();

        $images = $product->productImages()->get();

        return view('products.show', compact('product', 'variants', 'images'));
    }
}
