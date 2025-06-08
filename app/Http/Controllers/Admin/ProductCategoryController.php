<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    protected $productCategoryModel;
    protected $authenticatedUser;
    protected $activityLogModel;
    public function __construct()
    {
        $this->authenticatedUser = Auth::user();
        $this->productCategoryModel = ProductCategory::class;
        $this->activityLogModel = ActivityLog::class;
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
    //         'fields' => ['Number', 'store_name', 'users.username'],
    //         'query' => fn($model) => $model::with('users'),
    //     ],
    //     'product-categories' => [
    //         'title' => 'Product Category List',
    //         'columns' => ['No', 'Category Image', 'Category Name', 'Product Count'],
    //         'fields' => ['Number', 'category_image', 'category_name', 'products.count()'],
    //         'query' => fn($model) => $model::withCount('products'),
    // ]
    // ];

    public function index(Request $request, $getEntity)
    {
        $entity = $request->query('entity', $getEntity);
        $perPage = (int) $request->query('per_page', 10);
        $search_query = $request->query('search');
        $productCategoryConfig = [
            "title" => "Product Category List",
            'columns' => ['No', 'Category Image', 'Category Name', 'Product Count'],
            'fields' => ['Number', 'category_image', 'category_name', 'products_count'],
            'query' =>  $this->productCategoryModel::withCount('products'),
        ];

        if (!empty($search_query)) {
            $productCategoryConfig["query"]->where(function ($q) use ($search_query) {
                $q->where('category_name', 'like', "%{$search_query}%")
                    ->orWhere('description', 'like', "%{$search_query}%");
            });
        }

        $rows = $productCategoryConfig["query"]->paginate($perPage);
        $title = $productCategoryConfig["title"];
        $columns = $productCategoryConfig["columns"];
        $fields = $productCategoryConfig["fields"];
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

    public function getCreationPage(Request $request, $getEntity)
    {
        $entity = $request->query('entity', $getEntity);
        $title = "Create Product Category";
        $description = "Add a new product category to the system.";
        return view('Pages.Admin.Creation', compact('entity', 'title', 'description'));
    }

    public function create(Request $request, $getEntity)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'nullable|string',
            'category_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,avif',
        ]);

        $imagePath = null;
        if ($request->hasFile('category_banner')) {
            $imagePath = $request->file('category_banner')->store('category_images', 'public');
        }

        $slug = Str::slug($data['category_name']);

        $productCategory = $this->productCategoryModel::create([
            'category_name' => $data['category_name'],
            'slug' => $slug,
            'category_image' => basename($imagePath),
            'description' => $data['category_description'] ?? null,
        ]);

        $this->activityLogModel::create([
            "id_user" => $this->authenticatedUser->id_user,
            "action" => "create",
            "entity" => "product_categories",
            "target_id" => $productCategory->id_category,
            "notes" => "User {$this->authenticatedUser->username} created product category {$productCategory->name}"
        ]);

        return redirect()->route('admin.creation', $getEntity)
            ->with('success', Str::ucfirst(ucwords(str_replace('-', ' ', $getEntity))) . ' created successfully.');
    }
}
