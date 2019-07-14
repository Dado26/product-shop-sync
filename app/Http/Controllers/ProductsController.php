<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
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
        $search = $request->input('search');

        $searchWords = explode(' ', $search);

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

        return view('products.index', compact('products'));
    }

    public function import(ProductImportRequest $request)
    {
        ProductImportJob::dispatch($request->url, $request->category);

        flash('Your product was queued successfully, it will be processed soon.')->success();

        return redirect()->back();
    }
}
