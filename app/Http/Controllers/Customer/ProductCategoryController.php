<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    protected $categoryModel;
    protected $productModel;
    public function __construct()
    {
        $this->categoryModel = ProductCategory::class;
        $this->productModel = Product::class;
    }

    private function convertNameToSlug($name)
    {
        return Str::slug($name);
    }

    private function getTableConfig($category_slug)
    {
        $configs = [
            $this->convertNameToSlug("Gourmet Entrées") => [
                'title' => 'Gourmet Entrées',
                'query' => fn($model) => $model::whereHas('category', function ($q) {
                    $q->where('category_name', 'Gourmet Entrées');
                })
            ],
            $this->convertNameToSlug("Refined Refreshments") => [
                'title' => 'Refined Refreshments',
                'query' => fn($model) => $model::whereHas('category', function ($q) {
                    $q->where('category_name', 'Refined Refreshments');
                })
            ],
            $this->convertNameToSlug("Petite Pleasures") => [
                'title' => 'Petite Pleasures',
                'query' => fn($model) => $model::whereHas('category', function ($q) {
                    $q->where('category_name', 'Petite Pleasures');
                })
            ],
            $this->convertNameToSlug("Harvest Elegance") => [
                'title' => 'Harvest Elegance',
                'query' => fn($model) => $model::whereHas('category', function ($q) {
                    $q->where('category_name', 'Harvest Elegance');
                })
            ],
        ];
        return $configs[$category_slug] ?? null;
    }

    public function getProductByCategory(Request $request, $category_slug)
    {
        $category_slug = $request->query('category_slug', $category_slug);
        $search_query = $request->query('search');
        $perPage = (int) $request->query('per_page', 30);
        $config = $this->getTableConfig($category_slug);
        $query = ($config['query'])($this->productModel);
        if (!empty($search_query)) {
            $query = $query->where(function ($q) use ($search_query) {
                $q->where('product_name', 'like', "%{$search_query}%")
                    ->orWhere('description', 'like', "%{$search_query}%");
            });
        }
        $result = $query->paginate(10);
    }
}
