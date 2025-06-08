<?php

namespace App\Http\Controllers\Seller;

use App\Models\Store;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productModel;
    protected $authenticatedUser;
    protected $productCategory;
    public function __construct()
    {
        $this->productCategory = ProductCategory::class;
        $this->productModel = Product::class;
        $this->authenticatedUser = Auth::user();
    }
    public function index()
    {
        // Get all store IDs for the authenticated seller
        $storeIds = $this->authenticatedUser->stores->pluck('id_store');

        // Get all products for those stores, eager load store and category
        $products = $this->productModel::with(['store', 'category'])
            ->whereIn('id_store', $storeIds)
            ->orderByDesc('created_at')
            ->paginate(10);

        foreach ($products as $product) {
            $product->product_popup_data = [
                "product_id" => $product->id_product,
                "product_name" => $product->product_name,
                "product_price" => $product->price,
                "product_stock" => $product->stock,
                "product_image" => $product->product_image,
                "product_description" => $product->description,
                "product_created_at" => \Carbon\Carbon::parse($product->created_at)->format('d M Y H:i:s'),
                "product_updated_at" => \Carbon\Carbon::parse($product->updated_at)->format('d M Y H:i:s'),
                "product_category" => $product->category->category_name,
                "from_store" => $product->store->store_name,
            ];
        }

        // If this is an AJAX request, return JSON
        if (request()->ajax()) {
            return response()->json($products);
        }

        return view('Pages.Seller.MyProducts', compact('products'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();
        $stores = $this->authenticatedUser->stores;
        return view('Pages.Seller.ProductEdit', compact('product', 'categories', 'stores'));
    }

    public function createProduct()
    {
        $categories = $this->productCategory::all();
        $stores = $this->authenticatedUser->stores;
        return view('Pages.Seller.ProductCreation', compact('categories', 'stores'));
    }

    // Show detail of a product (show)
    public function show(Product $product)
    {
        $product->load('category');
        return view('Pages.Seller.ShowProduct', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $rawPrice = $request->input('price');
        $sanitizedPrice = str_replace(['.', ','], '', $rawPrice);
        $request->merge(['price' => $sanitizedPrice]);

        $validated = $request->validate([
            'product_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Optional: update slug jika product_name berubah
        if ($validated['product_name'] !== $product->product_name) {
            $base = Str::slug($validated['product_name']);
            $slug = $base;
            $i = 1;
            while (Product::where('slug', $slug)->where('id_product', '!=', $product->id_product)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $validated['slug'] = $slug;
        }

        // Handle product image upload
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('product_images', 'public');
            $validated['product_image'] = basename($path);
        }

        $product->update($validated);

        return redirect()->route('seller.products.list')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('seller.products.list')->with('success', 'Product deleted!');
    }

    public function makeProduct(Request $request)
    {
        // Sanitize price: hilangkan titik dan koma sebelum validasi
        $rawPrice = $request->input('price');
        $sanitizedPrice = str_replace(['.', ','], '', $rawPrice);
        $request->merge(['price' => $sanitizedPrice]);

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
        $base = \Illuminate\Support\Str::slug($validated['product_name']);
        $slug = $base;
        $i = 1;
        while ($this->productModel::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        $validated['slug'] = $slug;

        // Handle product image upload
        if ($request->hasFile('product_image')) {
            $path = $request->file('product_image')->store('product_images', 'public');
            $validated['product_image'] = basename($path);
        }

        // Simpan data ke database
        $product = $this->productModel::create($validated);

        return redirect()->route('seller.products.list')
            ->with('success', 'Product created successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->query('term');
        $storeIds = $this->authenticatedUser->stores->pluck('id_store');

        // Search for products matching the term
        $products = $this->productModel::with(['store', 'category'])
            ->whereIn('id_store', $storeIds)
            ->where(function ($query) use ($searchTerm) {
                $query->where('product_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('category', function ($q) use ($searchTerm) {
                        $q->where('category_name', 'LIKE', "%{$searchTerm}%");
                    });
            })
            ->get();

        // Add popup data for each product
        foreach ($products as $product) {
            $product->product_popup_data = [
                "product_id" => $product->id_product,
                "product_name" => $product->product_name,
                "product_price" => $product->price,
                "product_stock" => $product->stock,
                "product_image" => $product->product_image,
                "product_description" => $product->description,
                "product_created_at" => \Carbon\Carbon::parse($product->created_at)->format('d M Y H:i:s'),
                "product_updated_at" => \Carbon\Carbon::parse($product->updated_at)->format('d M Y H:i:s'),
                "product_category" => $product->category->category_name,
                "from_store" => $product->store->store_name,
            ];
        }

        return response()->json($products);
    }

    /**
     * Filter products by stock status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $filter = $request->query('status');
        $storeIds = $this->authenticatedUser->stores->pluck('id_store');

        $query = $this->productModel::with(['store', 'category'])
            ->whereIn('id_store', $storeIds);

        // Apply filter
        switch ($filter) {
            case 'in_stock':
                $query->where('stock', '>', 0);
                break;
            case 'out_of_stock':
                $query->where('stock', '<=', 0);
                break;
            case 'low_stock':
                $query->where('stock', '>', 0)->where('stock', '<=', 10);
                break;
        }

        $sortBy = $request->query('sort');
        switch ($sortBy) {
            case 'price_low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_to_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('product_name', 'asc');
                break;
            default:
                $query->orderByDesc('created_at');
                break;
        }

        $products = $query->get();

        // Add popup data for each product
        foreach ($products as $product) {
            $product->product_popup_data = [
                "product_id" => $product->id_product,
                "product_name" => $product->product_name,
                "product_price" => $product->price,
                "product_stock" => $product->stock,
                "product_image" => $product->product_image,
                "product_description" => $product->description,
                "product_created_at" => \Carbon\Carbon::parse($product->created_at)->format('d M Y H:i:s'),
                "product_updated_at" => \Carbon\Carbon::parse($product->updated_at)->format('d M Y H:i:s'),
                "product_category" => $product->category->category_name,
                "from_store" => $product->store->store_name,
            ];
        }

        if ($request->ajax()) {
            return response()->json($products);
        }

        return view('Pages.Seller.MyProducts', compact('products', 'filter'));
    }

    /**
     * Manage product categories
     *
     * @return \Illuminate\View\View
     */
    public function manageCategories()
    {
        $categories = $this->productCategory::orderBy('category_name')->get();
        return view('Pages.Seller.ManageCategories', compact('categories'));
    }
}
