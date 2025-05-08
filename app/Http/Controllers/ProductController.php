<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    public function index()
    {
        $products = QueryBuilder::for(Product::class)
            ->defaultSort('-created_at')
            ->allowedSorts('created_at', 'price')
            ->allowedFilters([AllowedFilter::exact('category', 'categories.id')])
            ->with('media')
            ->where('name', 'like', '%'.request('search').'%')
            ->paginate(20);
        return view('products.products', compact('products'));
    }

    public function show(Product $product)
    {
        $product = $product->load('media');
        $randomProducts = Product::with('media')->inRandomOrder()->limit(5)->get();
        return view('products.product', compact('product', 'randomProducts'));
    }
}
