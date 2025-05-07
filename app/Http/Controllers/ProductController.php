<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {

    }

    public function show(Product $product)
    {
        $product = $product->load('media');
        $randomProducts = Product::inRandomOrder()->limit(5)->get();
        return view('products.product', compact('product', 'randomProducts'));
    }
}
