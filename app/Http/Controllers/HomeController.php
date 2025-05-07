<?php

namespace App\Http\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function __invoke()
    {
        $featuredCategories = Category::where('featured', true)->with('media')->get();
        $landingCategories = Category::where('landing', true)->with(['products' => function($q) {
            $q->with('media')->latest()->take(5);
        }])->get();
        return view('welcome', compact('featuredCategories', 'landingCategories'));
    }
}
