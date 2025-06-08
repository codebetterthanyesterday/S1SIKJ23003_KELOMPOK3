<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productModel;
    protected $activityLogModel;
    protected $authenticatedUser;
    public function __construct()
    {
        $this->productModel = Product::class;
        $this->activityLogModel = ActivityLog::class;
        $this->authenticatedUser = Auth::user();
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
    //         'fields' => ['Number', 'product_name', 'store.store_name', 'price'],
    //         'query' => fn($model) => $model::with('store'),
    //     ],
    //     'store' => [
    //         'title' => 'Store List',
    //         'columns' => ['No', 'Store Name', 'Owner'],
    //         'fields' => ['Number', 'store_name', 'users.username'],
    //         'query' => fn($model) => $model::with('users'),
    //     ],
    // ];

    public function index(Request $request, $getEntity)
    {
        $entity = $request->query('entity', $getEntity);
        $perPage = (int) $request->query('per_page', 10);
        $search_query = $request->query('search');
        $productConfig = [
            'title' => 'Product List',
            'columns' => ['No', 'Product Name', 'Store Name', 'Price'],
            'fields' => ['Number', 'product_name', 'store.store_name', 'price'],
            'query' => $this->productModel::with('store'),
        ];
        if (!empty($search_query)) {
            $productConfig["query"]->where(function ($q) use ($search_query) {
                $q->where('product_name', 'like', "%{$search_query}%")
                    ->orWhere('price', 'like', "%{$search_query}%");
            });
        }
        $rows = $productConfig["query"]->paginate($perPage);
        $title = $productConfig["title"];
        $columns = $productConfig["columns"];
        $fields = $productConfig["fields"];
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

    // Show detail product
    public function show($id)
    {
        $product = $this->productModel::with('store')->findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    // Delete product
    public function destroy($id)
    {
        $product = $this->productModel::findOrFail($id);
        $product->delete();

        // Log activity
        $this->activityLogModel::create([
            'user_id' => $this->authenticatedUser->id,
            'action' => 'delete',
            'model' => 'Product',
            'model_id' => $product->id,
            'description' => "Deleted product {$product->name}",
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
    }

    // Restore product
    public function restore($id)
    {
        $product = $this->productModel::withTrashed()->findOrFail($id);
        $product->restore();

        // Log activity
        $this->activityLogModel::create([
            'user_id' => $this->authenticatedUser->id,
            'action' => 'restore',
            'model' => 'Product',
            'model_id' => $product->id,
            'description' => "Restored product {$product->name}",
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product restored successfully');
    }

    // Force delete product
    public function forceDelete($id)
    {
        $product = $this->productModel::withTrashed()->findOrFail($id);
        $product->forceDelete();

        // Log activity
        $this->activityLogModel::create([
            'user_id' => $this->authenticatedUser->id,
            'action' => 'force_delete',
            'model' => 'Product',
            'model_id' => $product->id,
            'description' => "Force deleted product {$product->name}",
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Product permanently deleted');
    }

    // Search product
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = $this->productModel::with('store')
            ->where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate(10);

        return view('admin.product.index', compact('products'));
    }
}
