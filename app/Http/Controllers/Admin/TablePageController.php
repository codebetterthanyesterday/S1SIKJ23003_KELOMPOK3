<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TablePageController extends Controller
{
    protected $userModel;
    protected $productModel;
    protected $storeModel;
    public function __construct()
    {
        $this->userModel = User::class;
        $this->productModel = Product::class;
        $this->storeModel = Store::class;
    }

    private function getTableConfig($filter_table)
    {
        $configs = [
            'customers' => [
                'title' => 'Customer List',
                'columns' => ['No', 'Username', 'Email'],
                'fields' => ['Number', 'username', 'email'],
                'query' => fn($model) => $model::whereHas('roles', fn($q) => $q->where('role_name', 'customer')),
            ],
            'sellers' => [
                'title' => 'Seller List',
                'columns' => ['No', 'Username', 'Email'],
                'fields' => ['Number', 'username', 'email'],
                'query' => fn($model) => $model::whereHas('roles', fn($q) => $q->where('role_name', 'seller')),
            ],
            'products' => [
                'title' => 'Product List',
                'columns' => ['No', 'Product Name', 'Store Name', 'Price'],
                'fields' => ['Number', 'product_name', 'stores.store_name', 'price'],
                'query' => fn($model) => $model::with('stores'),
            ],
            'stores' => [
                'title' => 'Store List',
                'columns' => ['No', 'Store Name', 'Owner'],
                'fields' => ['Number', 'store_name', 'users.username'],
                'query' => fn($model) => $model::with('users'),
            ],
        ];
        return $configs[$filter_table] ?? null;
    }

    public function getTable(Request $request, $filter)
    {
        $filter_table = $request->query('filter_table', $filter);
        $perPage = (int) $request->query('per_page', 10);
        $search_query = $request->query('search');
        $config = $this->getTableConfig($filter_table);

        if (!$config) {
            return view('pages.admin.table', compact('filter_table'));
        }

        $model = match ($filter_table) {
            'customers', 'sellers' => $this->userModel,
            'products' => $this->productModel,
            'stores' => $this->storeModel,
        };

        $query = ($config['query'])($model);

        if (!empty($search_query)) {
            switch ($filter_table) {
                case 'customers':
                case 'sellers':
                    $query = $query->where(function ($q) use ($search_query) {
                        $q->where('username', 'like', "%{$search_query}%")
                            ->orWhere('email', 'like', "%{$search_query}%");
                    });
                    break;
                case 'products':
                    $query = $query->where(function ($q) use ($search_query) {
                        $q->where('product_name', 'like', "%{$search_query}%")
                            ->orWhere('price', 'like', "%{$search_query}%");
                    });
                    break;
                case 'stores':
                    $query = $query->where('store_name', 'like', "%{$search_query}%");
                    break;
            }
        }

        $rows = $query->paginate($perPage);

        $title = $config['title'];
        $columns = $config['columns'];
        $fields = $config['fields'];

        return view('pages.admin.table', compact('filter_table', 'title', 'columns', 'fields', 'rows', 'perPage'));
    }

    // public function changePerPage(Request $request, $filter)
    // {

    // }
}
