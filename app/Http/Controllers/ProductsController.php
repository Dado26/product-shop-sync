<?php

namespace App\Http\Controllers;

use App\Helpers\SiteUrlParser;
use App\Models\Product;
use App\Jobs\ProductSyncJob;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Jobs\ProductImportJob;
use App\Http\Requests\ProductImportRequest;
use App\Models\ShopCategory;
use Queue;

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
        $search = $request->input('search');

        $searchWords   = explode(' ', $search);

        $categories    = ShopCategory::with('languageCategoryDescriptions')->get();

        $products = Product::query()
                           ->where(function ($query) use ($searchWords) {
                               foreach ($searchWords as $searchWord) {
                                   $query->orWhere('title', 'LIKE', "%$searchWord%")
                                         ->orWhere('id', 'LIKE', "%$searchWord%");
                               }
                           })
                           ->with(['site', 'variants'])
                           ->latest()
                           ->paginate();

        return view('products.index', compact('products', 'categories'));
    }

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
            ProductImportJob::dispatch($request->url, $request->category);

            flash('Your product was queued successfully, it will be processed soon.')->success();
        }

        return redirect()->back();
    }

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

    public function show(Product $product)
    {
        $variants =$product->variants()->get();

        $images = $product->productImages()->get();

        return view('products.show', compact('product', 'variants', 'images'));
    }
}
