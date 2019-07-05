<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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

        $products = Product::query()
            ->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%$search%")
                      ->orWhere('title', 'LIKE', "%$search%");
            })
            ->with(['site', 'variants'])
            ->latest()
            ->paginate();

        return view('products.index', compact('products'));
    }
}
