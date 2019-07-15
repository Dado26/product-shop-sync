<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use App\Jobs\ProductSyncJob;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Jobs\ProductImportJob;
use App\Http\Requests\ProductImportRequest;
use App\Models\ShopCategory;

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
        ProductImportJob::dispatch($request->url, $request->category);

        flash('Your product was queued successfully, it will be processed soon.')->success();

        return redirect()->back();
    }

    public function sync(Product $product)
    {
        try {
            ProductSyncJob::dispatchNow($product);

            flash('Your product is being synchronized')->success();

            return redirect()->back();
        } catch (InvalidArgumentException $e) {
            logger()->notice('Failed to find required product data, maybe it was removed');
        }

        return redirect()->back();
    }

    public function show(Product $product)
    {
        $variants =  Variant::where('product_id', $product->id)->get();

        $images   = ProductImage::where('product_id', $product->id)->get();

        return view('products.show', compact('product', 'variants', 'images'));
    }
}
