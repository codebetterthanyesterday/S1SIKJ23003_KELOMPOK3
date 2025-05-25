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

    // Retrieve All Data Products (Pagination)
    public function index($filter_table)
    {
        $products = $this->productModel::with('store')->paginate(10);
        $filter = $filter_table;
        return view('pages.admin.table', compact('products', 'filter'));
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
