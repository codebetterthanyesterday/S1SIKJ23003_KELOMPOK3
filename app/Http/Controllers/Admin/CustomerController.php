<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
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
        $customerConfig = [
            "title" => "Customer List",
            "columns" => ["No", "Username", "Email"],
            "fields" => ["Number", "username", "email"],
            "query" => $this->userModel::whereHas('roles', fn($q) => $q->where('role_name', 'customer'))
        ];

        if (!empty($search_query)) {
            $customerConfig["query"]->where(function ($q) use ($search_query) {
                $q->where('username', 'like', "%{$search_query}%")->orWhere('email', 'like', "%{$search_query}%");
            });
        }

        $rows = $customerConfig["query"]->paginate($perPage);
        $title = $customerConfig["title"];
        $columns = $customerConfig["columns"];
        $fields = $customerConfig["fields"];
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

        // foreach ($rows as $row) {
        //     $row->Number = $AInumber++;
        // }
        $data = [
            'entity' => $entity,
            'rows' => $rows,
            'title' => $title,
            'columns' => $columns,
            'fields' => $fields,
            'AInumber' => $AInumber,
        ];
        return view('pages.admin.table', compact('data'));
        // return view('pages.admin.table', compact('entity', 'rows', 'title', 'columns', 'fields', 'testing'));
    }
}
