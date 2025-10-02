<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        $products = Product::active()->take(8)->get();
        $featuredProducts = Product::active()->featured()->take(8)->get();
        return view('public.welcome', compact('products', 'featuredProducts'));
    }

    public function productDetails($id)
    {
        $product = Product::where('slug', $id)->firstOrFail();

        if (!$product->is_active) {
            return to_route('public.welcome')->with('error', 'Product is not available.');
        }
        return view('public.product-show', compact('product'));
    }
}
