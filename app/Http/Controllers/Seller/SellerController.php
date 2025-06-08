<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id_user;

        $totalProducts = \App\Models\Product::whereHas('store', function ($q) use ($userId) {
            $q->where('id_user', $userId);
        })->count();

        // Get all store IDs for the authenticated seller
        $storeIds = \App\Models\Store::where('id_user', $userId)->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = \App\Models\Product::whereIn('id_store', $storeIds)->pluck('id_product');

        // Get all order IDs from OrderDetail where id_product is in the seller's products
        $orderIds = \App\Models\OrderDetail::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        // Calculate total revenue from orders that contain the seller's products
        $totalRevenue = \App\Models\Order::whereIn('id_order', $orderIds)
            ->whereIn('order_status', ['approved', 'delivered', 'shipped'])
            ->sum('total_amount');

        // Low stock (<=5) and out-of-stock products
        $lowStockProducts = \App\Models\Product::whereHas('store', function ($q) use ($userId) {
            $q->where('id_user', $userId);
        })->where('stock', '<=', 5)->where('stock', '>', 0)->count();

        $outOfStockProducts = \App\Models\Product::whereHas('store', function ($q) use ($userId) {
            $q->where('id_user', $userId);
        })->where('stock', '=', 0)->count();

        $totalStores = \App\Models\Store::where('id_user', $userId)->count();

        return view('Pages.Seller.Dashboard', compact('totalProducts', 'totalRevenue', 'totalStores', 'lowStockProducts', 'outOfStockProducts'));
    }

    public function getCreation(Request $request, $filter_entity)
    {
        $entity = $request->query("entity", $filter_entity);
        switch ($entity) {
            case 'store':
                return app(StoreController::class)->createStore();
                break;
            case 'product':
                return app(ProductController::class)->createProduct();
                break;
            default:
                abort(404, "Page not found");
                break;
        }
    }

    public function getList(Request $request, $filter_entity)
    {
        $entity = $request->query("entity", $filter_entity);
        switch ($entity) {
            case 'order':
                return app(OrderController::class)->index($request);
                break;
            case 'product':
                return app(ProductController::class)->index($request);
                break;
            case 'store':
                return app(StoreController::class)->index($request);
                break;
            default:
                abort(404, "Page not found");
                break;
        }
    }

    public function handleCreation($entity, Request $request)
    {
        switch ($entity) {
            case 'store':
                return app(StoreController::class)->openStore($request);
                break;
            case 'product':
                return app(ProductController::class)->makeProduct($request);
                break;
            default:
                abort(404, "Creation handler not found for this entity");
                break;
        }
    }

    // Returns sales data for the dashboard chart
    public function salesData()
    {
        $userId = Auth::user()->id_user;

        // Get all store IDs for the authenticated seller
        $storeIds = \App\Models\Store::where('id_user', $userId)->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = \App\Models\Product::whereIn('id_store', $storeIds)->pluck('id_product');

        // Get all order IDs from OrderDetail where id_product is in the seller's products
        $orderIds = \App\Models\OrderDetail::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        // Example: sales for the last 7 days
        $labels = [];
        $sales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = date('D', strtotime($date));
            $sales[] = \App\Models\Order::whereIn('id_order', $orderIds)
                ->whereIn('order_status', ['approved', 'delivered', 'shipped'])
                ->whereDate('created_at', $date)
                ->sum('total_amount');
        }
        return response()->json([
            'labels' => $labels,
            'sales' => $sales,
        ]);
    }

    // Returns recent orders for the dashboard table
    public function recentOrders()
    {
        $userId = Auth::user()->id_user;

        // Get all store IDs for the authenticated seller
        $storeIds = \App\Models\Store::where('id_user', $userId)->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = \App\Models\Product::whereIn('id_store', $storeIds)->pluck('id_product');

        // Get all order IDs from OrderDetail where id_product is in the seller's products
        $orderIds = \App\Models\OrderDetail::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        $orders = \App\Models\Order::with('user')
            ->whereIn('id_order', $orderIds)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $data = $orders->map(function ($order) {
            return [
                'id' => $order->id_order,
                'customer' => $order->user ? $order->user->username : 'N/A',
                'amount' => $order->total_amount,
                'status' => ucfirst($order->order_status),
                'date' => $order->created_at->format('Y-m-d H:i'),
            ];
        });
        return response()->json($data);
    }

    // Returns comparison data for expandable dashboard cards
    public function comparisonData()
    {
        // Products
        $userId = Auth::user()->id_user;
        $productsThisMonth = \App\Models\Product::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $productsLastMonth = \App\Models\Product::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $totalProductsOverall = \App\Models\Product::whereHas('store', function ($q) use ($userId) {
            $q->where('id_user', $userId);
        })->count();
        $productsShareThis = $totalProductsOverall == 0 ? 0 : ($productsThisMonth / $totalProductsOverall) * 100;
        $productsShareLast = $totalProductsOverall == 0 ? 0 : ($productsLastMonth / $totalProductsOverall) * 100;
        $productsChange = $productsShareThis - $productsShareLast;
        $productsChangeHtml = $this->formatChangeHtml($productsChange);

        // Get all store IDs for the authenticated seller
        $storeIds = \App\Models\Store::where('id_user', $userId)->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = \App\Models\Product::whereIn('id_store', $storeIds)->pluck('id_product');

        // Get all order IDs from OrderDetail where id_product is in the seller's products
        $orderIds = \App\Models\OrderDetail::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        // Revenue
        $revenueThisMonth = \App\Models\Order::whereIn('id_order', $orderIds)
            ->whereIn('order_status', ['approved', 'delivered', 'shipped'])
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total_amount');
        $revenueLastMonth = \App\Models\Order::whereIn('id_order', $orderIds)
            ->whereIn('order_status', ['approved', 'delivered', 'shipped'])
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('total_amount');
        $revenueChange = $revenueLastMonth == 0 ? ($revenueThisMonth > 0 ? 100 : 0) : (($revenueThisMonth - $revenueLastMonth) / max(1, $revenueLastMonth)) * 100;
        $revenueChangeHtml = $this->formatChangeHtml($revenueChange);

        // Stores (for the current seller)
        $storesThisMonth = \App\Models\Store::where('id_user', $userId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $storesLastMonth = \App\Models\Store::where('id_user', $userId)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $totalStoresOverall = \App\Models\Store::where('id_user', $userId)->count();
        $storesShareThis = $totalStoresOverall == 0 ? 0 : ($storesThisMonth / $totalStoresOverall) * 100;
        $storesShareLast = $totalStoresOverall == 0 ? 0 : ($storesLastMonth / $totalStoresOverall) * 100;
        $storesChange = $storesShareThis - $storesShareLast;
        $storesChangeHtml = $this->formatChangeHtml($storesChange);

        // Pending Orders
        $pendingThisMonth = \App\Models\Order::where('order_status', 'pending')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $pendingLastMonth = \App\Models\Order::where('order_status', 'pending')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $pendingChange = $pendingLastMonth == 0 ? ($pendingThisMonth > 0 ? 100 : 0) : (($pendingThisMonth - $pendingLastMonth) / max(1, $pendingLastMonth)) * 100;
        $pendingChangeHtml = $this->formatChangeHtml($pendingChange);

        return response()->json([
            'products' => [
                'this_month' => $productsThisMonth,
                'last_month' => $productsLastMonth,
                'change' => $productsChange,
                'change_html' => $productsChangeHtml,
            ],
            'revenue' => [
                'this_month' => $revenueThisMonth,
                'last_month' => $revenueLastMonth,
                'change' => $revenueChange,
                'change_html' => $revenueChangeHtml,
            ],
            'stores' => [
                'this_month' => $storesThisMonth,
                'last_month' => $storesLastMonth,
                'change' => $storesChange,
                'change_html' => $storesChangeHtml,
            ],
            'pending' => [
                'this_month' => $pendingThisMonth,
                'last_month' => $pendingLastMonth,
                'change' => $pendingChange,
                'change_html' => $pendingChangeHtml,
            ],
        ]);
    }

    // Helper to format the change with arrow and color
    private function formatChangeHtml($change)
    {
        $arrow = $change > 0 ? '↑' : ($change < 0 ? '↓' : '→');
        $color = $change > 0 ? 'text-green-600' : ($change < 0 ? 'text-red-600' : 'text-gray-600');
        $percent = number_format(abs($change), 1);
        return "<span class=\"$color font-bold\">$arrow $percent%</span>";
    }
}
