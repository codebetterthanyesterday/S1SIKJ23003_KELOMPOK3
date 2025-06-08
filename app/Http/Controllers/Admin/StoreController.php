<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    protected $storeModel;

    public function __construct()
    {
        $this->storeModel = Store::class;
    }

    // $configs = [
    //     'customers' => [
    //         'title' => 'Customer List',
    //         'columns' => ['No', 'Username', 'Email'],
    //         'fields' => ['Number', 'username', 'email'],
    //         'query' => fn($model) => $model::whereHas('roles', fn($q) => $q->where('role_name', 'customer')),
    //     ],
    //     'sellers' => [
    //         'title' => 'Seller List',
    //         'columns' => ['No', 'Username', 'Email'],
    //         'fields' => ['Number', 'username', 'email'],
    //         'query' => fn($model) => $model::whereHas('roles', fn($q) => $q->where('role_name', 'seller')),
    //     ],
    //     'products' => [
    //         'title' => 'Product List',
    //         'columns' => ['No', 'Product Name', 'Store Name', 'Price'],
    //         'fields' => ['Number', 'product_name', 'stores.store_name', 'price'],
    //         'query' => fn($model) => $model::with('stores'),
    //     ],
    //     'stores' => [
    //         'title' => 'Store List',
    //         'columns' => ['No', 'Store Name', 'Owner'],
    //         'fields' => ['Number', 'store_name', 'owner.username'],
    //         'query' => fn($model) => $model::with('owner'),
    //     ],
    // ];

    public function index(Request $request, $getEntity)
    {
        $entity = $request->query('entity', $getEntity);
        $perPage = (int) $request->query('per_page', 10);
        $search_query = $request->query('search');
        $storeConfig = [
            'title' => 'Store List',
            'columns' => ['No', 'Store Name', 'Owner'],
            'fields' => ['Number', 'store_name', 'owner.username'],
            "query" => $this->storeModel::with('owner')
        ];

        if (!empty($search_query)) {
            $storeConfig["query"]->where('store_name', 'like', "%{$search_query}%");
        }

        $rows = $storeConfig["query"]->paginate($perPage);
        $title = $storeConfig["title"];
        $columns = $storeConfig["columns"];
        $fields = $storeConfig["fields"];
        $AInumber = 1;

        // Map the data to flatten nested fields
        $mappedRows = $rows->getCollection()->map(function ($row) use ($fields) {
            $result = [];
            foreach ($fields as $field) {
                if (strpos($field, '.') !== false) {
                    // Handle nested fields like 'table.column'
                    $parts = explode('.', $field);
                    $value = $row;
                    foreach ($parts as $part) {
                        $value = $value ? $value->{$part} : null;
                    }
                    $result[$field] = $value;
                } else {
                    $result[$field] = $row->{$field};
                }
            }
            return $result;
        });

        // Replace the collection in the paginator
        $rows->setCollection($mappedRows);

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
