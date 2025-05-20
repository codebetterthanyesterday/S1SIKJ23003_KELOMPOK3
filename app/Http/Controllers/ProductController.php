<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productModel;
    public function __construct()
    {
        $this->productModel = Product::class;
    }
    public function show($id)
    {
        $this->productModel::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            
            // Add other validation rules as needed
        ]);

        $product = $this->productModel::create($validated);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product created successfully.');
    }

}
