<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Jobs\ProductImportJob;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $searchWords = explode(' ', $search);
           
        
        $products = Product::query()
            ->where(function ($query) use ($searchWords) {
                foreach($searchWords as $searchWord){
                    $query->orWhere('title', 'LIKE', "%$searchWord%")
                          ->orWhere('id', 'LIKE', "%$searchWord%");
                }
            })
        
            ->with(['site', 'variants'])
            ->latest()
            ->paginate();
        
        return view('products.index', compact('products'));
    }

    public function import(request $request){



        $param = $request->validate([
            'url' => 'required|url',
            'category' => 'required'
        ]);
        
       ProductImportJob::dispatch($param['url'], $param['category']);

       flash('You have successfully imported product')->success();

       return redirect()->back();

    }
}
