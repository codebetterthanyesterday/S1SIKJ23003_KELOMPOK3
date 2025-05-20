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


}
