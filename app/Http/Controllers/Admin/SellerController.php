<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class SellerController extends Controller
{

    protected $userModel;
    public function __construct()
    {
        $this->userModel = User::class;
    }

    public function index(Request $request, $getEntity)
    {
        $entity = $request->query('entity', $getEntity);
        $perPage = (int) $request->query('per_page', 10);
        $search_query = $request->query('search');
        $sellerConfig = [
            "title" => "Seller List",
            "columns" => ["No", "Username", "Email"],
            "fields" => ["Number", "username", "email"],
            "query" => $this->userModel::whereHas('roles', fn($q) => $q->where('role_name', 'seller'))
        ];

        if (!empty($search_query)) {
            $sellerConfig["query"]->where(function ($q) use ($search_query) {
                $q->where('username', 'like', "%{$search_query}%")->orWhere('email', 'like', "%{$search_query}%");
            });
        }

        $rows = $sellerConfig["query"]->paginate($perPage);
        $title = $sellerConfig["title"];
        $columns = $sellerConfig["columns"];
        $fields = $sellerConfig["fields"];
        $AInumber = 1;

        if ($request->ajax()) {
            return response()->json([
                "columns" => $fields,
                "data" => $rows->items(),
                "pagination" => [
                    "total" => $rows->total(),
                    "from" => $rows->firstItem(),
                    "to" => $rows->lastItem(),
                    "current_page" => $rows->currentPage(),
                    "last_page" => $rows->lastPage(),
                ]
            ]);
        }

        $data = [
            'entity' => $entity,
            'rows' => $rows,
            'title' => $title,
            'columns' => $columns,
            'fields' => $fields,
            'AInumber' => $AInumber,
        ];

        return view('Pages.Admin.Table', compact('data'));
    }
}
