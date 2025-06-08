<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display the store page with its products
     */
    public function show($slug)
    {
        $store = Store::where('slug', $slug)->with('products')->firstOrFail();

        return view('Pages.Visitor.Store', compact('store'));
    }
}
