<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index($filter_table)
    {
        $filter = $filter_table;
        return view('pages.admin.table', compact('filter'));
    }
}
