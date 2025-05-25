<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index($filter_table) {
        return view('pages.admin.table', compact('filter_table'));
    }
}
