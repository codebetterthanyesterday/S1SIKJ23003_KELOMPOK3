<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productModel;
    public function __construct()
    {
        $this->productModel = Product::class;
    }

    public function index ()
    {
        $products = $this->productModel::paginate(10);
        return view('Pages.Admin.Table', compact('products'));
    }

    public function show($id)
    {
        $this->productModel::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'id_store' => 'required|exists:stores,id_store',
            'id_category' => 'required|exists:product_categories,id_category',
            'product_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate a unique slug
        $base = Str::slug($validated['product_name']);
        $slug = $base;
        $i = 1;
        while ($this->productModel::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        $validated['slug'] = $slug;

        // Handle product image upload
        if ($request->hasFile('product_image')) {
            $validated['product_image'] = $request->file('product_image')
                ->store('products', 'public');
        }

        $product = $this->productModel::create($validated);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product created successfully.');
    }

}
