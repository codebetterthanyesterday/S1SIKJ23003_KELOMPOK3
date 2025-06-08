<?php

namespace App\Http\Controllers\Seller;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    protected $orderModel;
    protected $userModel;
    protected $productModel;
    protected $orderDetailModel;

    public function __construct()
    {
        $this->orderModel = Order::class;
        $this->userModel = User::class;
        $this->productModel = Product::class;
        $this->orderDetailModel = OrderDetail::class;
    }

    public function index()
    {
        $authenticatedUser = Auth::user();

        // Get all store IDs for the authenticated seller
        $storeIds = $authenticatedUser->stores->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = $this->productModel::whereIn('id_store', $storeIds)->pluck('id_product');

        // Get all order IDs from OrderDetail where id_product is in the seller's products
        $orderIds = $this->orderDetailModel::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        // Fetch the orders with those IDs, eager load user and order details
        $orders = $this->orderModel::with(['user', 'details.product.store', 'payments'])
            ->whereIn('id_order', $orderIds)
            ->orderByDesc('order_date')
            ->paginate(10);

        foreach ($orders as $order) {
            $order->order_popup_data = [
                'customer' => $order->user->username ?? '-',
                'order_in' => \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i:s'),
                'total_amount' => 'Rp. ' . number_format($order->total_amount, 0, ',', '.'),
                'products' => $order->details->map(function ($detail) {
                    return [
                        'product_name' => $detail->product->product_name ?? '-',
                        'quantity' => $detail->quantity,
                        'store_name' => $detail->product->store->store_name ?? '-',
                    ];
                })->all(),
                'payment_method' => $order->payments->first()->method ?? '-',
                'payment_status' => $order->payments->first()->payment_status ?? '-',
            ];
        }

        return view('Pages.Seller.Orders', compact('orders'));
    }

    /**
     * Update order status to approved
     */
    public function approveOrder($orderId)
    {
        $order = $this->orderModel::with('user')->findOrFail($orderId);

        // Verify seller has authority over this order
        if (!$this->sellerHasAuthorityOverOrder($order)) {
            return redirect()->back()->with('error', 'You do not have authority over this order.');
        }

        $order->order_status = 'approved';
        $order->save();

        // Send email notification
        $statusMessage = 'Your order has been approved and we are preparing your items.';
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $statusMessage));
        }

        return redirect()->back()->with('success', 'Order has been approved.');
    }

    /**
     * Update order status to rejected
     */
    public function rejectOrder(Request $request, $orderId)
    {
        $request->validate([
            'rejection_reason' => 'nullable|string|max:255'
        ]);

        $order = $this->orderModel::with(['user', 'details.product'])->findOrFail($orderId);

        // Verify seller has authority over this order
        if (!$this->sellerHasAuthorityOverOrder($order)) {
            return redirect()->back()->with('error', 'You do not have authority over this order.');
        }

        // Restore product stock
        foreach ($order->details as $detail) {
            $product = $detail->product;
            $product->stock += $detail->quantity;
            $product->save();
        }

        $order->order_status = 'rejected';
        $order->rejection_reason = $request->rejection_reason;
        $order->save();

        // Send email notification
        $statusMessage = 'We regret to inform you that your order has been rejected.';
        if ($request->rejection_reason) {
            $statusMessage .= ' Reason: ' . $request->rejection_reason;
        }

        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $statusMessage));
        }

        return redirect()->back()->with('success', 'Order has been rejected.');
    }

    /**
     * Update order status to shipped
     */
    public function markAsShipped(Request $request, $orderId)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:100',
            'shipping_notes' => 'nullable|string|max:255',
        ]);

        $order = $this->orderModel::with('user')->findOrFail($orderId);

        // Verify seller has authority over this order
        if (!$this->sellerHasAuthorityOverOrder($order)) {
            return redirect()->back()->with('error', 'You do not have authority over this order.');
        }

        $order->order_status = 'shipped';
        $order->tracking_number = $request->tracking_number;
        $order->shipping_notes = $request->shipping_notes;
        $order->save();

        // Send email notification
        $statusMessage = 'Great news! Your order has been shipped and is on its way to you.';
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $statusMessage));
        }

        return redirect()->back()->with('success', 'Order has been marked as shipped.');
    }

    /**
     * Update order status to delivered
     */
    public function markAsDelivered($orderId)
    {
        $order = $this->orderModel::with('user')->findOrFail($orderId);

        // Verify seller has authority over this order
        if (!$this->sellerHasAuthorityOverOrder($order)) {
            return redirect()->back()->with('error', 'You do not have authority over this order.');
        }

        $order->order_status = 'delivered';
        $order->save();

        // Send email notification
        $statusMessage = 'Your order has been marked as delivered. We hope you enjoy your purchase!';
        if ($order->user && $order->user->email) {
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order, $statusMessage));
        }

        return redirect()->back()->with('success', 'Order has been marked as delivered.');
    }

    /**
     * Filter orders by status
     */
    public function filterOrders(Request $request)
    {
        $authenticatedUser = Auth::user();
        $status = $request->input('status', 'all');

        // Get all store IDs for the authenticated seller
        $storeIds = $authenticatedUser->stores->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = $this->productModel::whereIn('id_store', $storeIds)->pluck('id_product');

        // Get all order IDs from OrderDetail where id_product is in the seller's products
        $orderIds = $this->orderDetailModel::whereIn('id_product', $productIds)->pluck('id_order')->unique();

        // Base query
        $query = $this->orderModel::with(['user', 'details.product.store', 'payments'])
            ->whereIn('id_order', $orderIds);

        // Apply status filter if not 'all'
        if ($status !== 'all') {
            $query->where('order_status', $status);
        }

        // Get orders
        $orders = $query->orderByDesc('order_date')->paginate(10);

        foreach ($orders as $order) {
            $order->order_popup_data = [
                'customer' => $order->user->username ?? '-',
                'order_in' => \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i:s'),
                'total_amount' => 'Rp. ' . number_format($order->total_amount, 0, ',', '.'),
                'products' => $order->details->map(function ($detail) {
                    return [
                        'product_name' => $detail->product->product_name ?? '-',
                        'quantity' => $detail->quantity,
                        'store_name' => $detail->product->store->store_name ?? '-',
                    ];
                })->all(),
                'payment_method' => $order->payments->first()->method ?? '-',
                'payment_status' => $order->payments->first()->payment_status ?? '-',
            ];
        }

        return view('Pages.Seller.Orders', compact('orders', 'status'));
    }

    /**
     * Search orders by customer username
     */
    public function searchOrders(Request $request)
    {
        $authenticatedUser = Auth::user();
        $search = $request->input('search');

        // Get all store IDs for the authenticated seller
        $storeIds = $authenticatedUser->stores->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = $this->productModel::whereIn('id_store', $storeIds)->pluck('id_product');

        // Build the base query using a subquery to get seller's orders
        $query = $this->orderModel::query()
            ->whereHas('details.product', function ($q) use ($productIds) {
                $q->whereIn('id_product', $productIds);
            })
            ->with(['user', 'details.product.store', 'payments']);

        // Apply search filter if search term exists
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q) use ($search) {
                    $q->where('username', 'like', '%' . $search . '%');
                })
                    ->orWhere('order_status', 'like', '%' . $search . '%')
                    ->orWhereHas('payments', function ($q) use ($search) {
                        $q->where('method', 'like', '%' . $search . '%')
                            ->orWhere('payment_status', 'like', '%' . $search . '%');
                    });
            });
        }

        // Get orders with pagination
        $orders = $query->orderByDesc('order_date')->paginate(10);

        // Prepare order data
        foreach ($orders as $order) {
            $order->order_popup_data = [
                'customer' => $order->user->username ?? '-',
                'order_in' => \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i:s'),
                'total_amount' => 'Rp. ' . number_format($order->total_amount, 0, ',', '.'),
                'products' => $order->details->map(function ($detail) {
                    return [
                        'product_name' => $detail->product->product_name ?? '-',
                        'quantity' => $detail->quantity,
                        'store_name' => $detail->product->store->store_name ?? '-',
                    ];
                })->all(),
                'payment_method' => $order->payments->first()->method ?? '-',
                'payment_status' => $order->payments->first()->payment_status ?? '-',
            ];
        }

        // If it's an AJAX request, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('Pages.Seller.Orders', compact('orders', 'search'))->render(),
                'hasResults' => $orders->isNotEmpty()
            ]);
        }

        // For traditional form submission, return the view
        return view('Pages.Seller.Orders', compact('orders', 'search'));
    }

    /**
     * Helper method to verify seller authority over an order
     */
    private function sellerHasAuthorityOverOrder($order)
    {
        $authenticatedUser = Auth::user();

        // Get all store IDs for the authenticated seller
        $storeIds = $authenticatedUser->stores->pluck('id_store');

        // Get all product IDs for those stores
        $productIds = $this->productModel::whereIn('id_store', $storeIds)->pluck('id_product');

        // Check if any product in the order belongs to the seller's stores
        foreach ($order->details as $detail) {
            if (in_array($detail->product->id_product, $productIds->toArray())) {
                return true;
            }
        }

        return false;
    }
}
