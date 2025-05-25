<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function index($filter_table) {
        // $products = Product::with('category')->paginate(10);
        $filter = $filter_table;
        return view('pages.admin.table', compact('filter'));
    }
}
