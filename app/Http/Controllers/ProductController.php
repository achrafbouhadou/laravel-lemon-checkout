<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Pass products to the Inertia view
        return Inertia::render('Home', [
            'products' => $products,
        ]);
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }

}
