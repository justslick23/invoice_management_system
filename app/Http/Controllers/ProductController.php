<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function index()
{
    $products = Product::all();
    return view('products.index', compact('products'));
}


    public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        // Add validation rules for other fields as needed
    ]);


    // Create a new product
    $product = new Product();
    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    // Set other fields as needed

    // Save the product to the database
    $product->save();

    // Redirect to a success page or a list of products
    return redirect('/products')->with('success', 'Product created successfully.');
}

}
