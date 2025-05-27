<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    protected $productCategoryModel;
    public function __construct()
    {
        $this->productCategoryModel = ProductCategory::class;
    }
    public function index($filter_table)
    {
        // $products = Product::with('category')->paginate(10);
        $filter = $filter_table;
        return view('pages.admin.table', compact('filter'));
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif',
        ]);

        $imagePath = null;
        if ($request->hasFile('category_image')) {
            $imagePath = $request->file('category_image')->store('category_images', 'public');
        }

        $this->productCategoryModel::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'category_image' => $imagePath,
        ]);

        return redirect()->route('admin.product_categories.index')->with('success', 'Product category created successfully');
    }
}
