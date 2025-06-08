<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;

class SearchController extends Controller
{
    public function liveSearch(Request $request)
{
    $q = $request->input('q');

    // Produk
    $products = Product::with(['category', 'store'])
        ->where('product_name', 'like', "%{$q}%")
        ->orWhere('description', 'like', "%{$q}%")
        ->orWhere('slug', 'like', "%{$q}%")
        ->orWhereHas('category', function($query) use ($q) {
            $query->where('category_name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhere('slug', 'like', "%{$q}%");
        })
        ->orWhereHas('store', function($query) use ($q) {
            $query->where('store_name', 'like', "%{$q}%");
        })
        ->limit(5)
        ->get();

    // Kategori
    $categories = ProductCategory::where('category_name', 'like', "%{$q}%")
        ->orWhere('description', 'like', "%{$q}%")
        ->orWhere('slug', 'like', "%{$q}%")
        ->limit(5)
        ->get();

    // Toko
    $stores = Store::where('store_name', 'like', "%{$q}%")
        ->orWhere('description', 'like', "%{$q}%")
        ->orWhere('store_address', 'like', "%{$q}%")
        ->orWhere('slug', 'like', "%{$q}%")
        ->limit(5)
        ->get();

    return response()->json([
        'products' => $products->map(function($item) {
            return [
                'id' => $item->id_product,
                'name' => $item->product_name,
                'description' => $item->description,
                'image_url' => $item->product_image ? asset('storage/product_images/' . $item->product_image) : null,
                'category' => $item->category ? [
                    'id' => $item->category->id_category,
                    'name' => $item->category->category_name
                ] : null,
                'store' => $item->store ? [
                    'id' => $item->store->id_store,
                    'name' => $item->store->store_name
                ] : null,
                'slug' => $item->slug,
            ];
        }),
        // 'categories' => $categories->map(function($cat) {
        //     return [
        //         'id' => $cat->id_category,
        //         'name' => $cat->category_name,
        //         'description' => $cat->description,
        //         'image_url' => $cat->category_image ? asset('storage/category_images/' . $cat->category_image) : null,
        //         'slug' => $cat->slug,
        //     ];
        // }),
        'stores' => $stores->map(function($store) {
            return [
                'id' => $store->id_store,
                'name' => $store->store_name,
                'description' => $store->description,
                'address' => $store->store_address,
                'image_url' => $store->store_logo ? asset('storage/store_logos/' . $store->store_logo) : null,
                'slug' => $store->slug,
            ];
        }),
    ]);
}
}
