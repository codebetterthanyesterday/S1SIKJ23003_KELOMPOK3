<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Show the payment page for an order
     */
    public function showPaymentPage($orderId)
    {
        $order = Order::with(['details.product'])->findOrFail($orderId);

        // Ensure the order belongs to the authenticated user
        if ($order->id_user !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access to order.');
        }

        return view('Pages.visitor.payment', compact('order'));
    }

    /**
     * Process the payment method selection
     */
    public function processPaymentMethod(Request $request, $orderId)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,cod,dana,shopeepay,gopay,ovo',
        ]);

        $order = Order::findOrFail($orderId);

        // Ensure the order belongs to the authenticated user
        if ($order->id_user !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access to order.');
        }

        $method = $request->payment_method;
        $paymentCategory = 'transfer'; // Default category

        // Determine payment category
        if ($method === 'cod') {
            $paymentCategory = 'cod';
        } elseif (in_array($method, ['dana', 'shopeepay', 'gopay', 'ovo'])) {
            $paymentCategory = 'ewallet';
        }

        // Create or update the payment record
        $payment = Payment::updateOrCreate(
            ['id_order' => $orderId],
            [
                'method' => $method,
                'payment_status' => 'unpaid',
                'payment_category' => $paymentCategory,
            ]
        );

        // For COD, we'll mark it as "paid upon delivery"
        if ($method === 'cod') {
            return redirect()->route('customer.payment.confirmation', $orderId)
                ->with('info', 'Your order will be processed for Cash on Delivery.');
        }

        // For transfer and ewallet, redirect to the appropriate payment page
        return redirect()->route('customer.payment.details', [
            'orderId' => $orderId,
            'method' => $method
        ]);
    }

    /**
     * Show payment details page based on method
     */
    public function showPaymentDetails($orderId, $method)
    {
        $order = Order::with(['details.product'])->findOrFail($orderId);
        $payment = Payment::where('id_order', $orderId)->firstOrFail();

        // Ensure the order belongs to the authenticated user
        if ($order->id_user !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access to order.');
        }

        return view('Pages.Visitor.payment_details', compact('order', 'payment', 'method'));
    }

    /**
     * Process payment confirmation
     */
    public function confirmPayment(Request $request, $orderId)
    {
        $request->validate([
            'payment_proof' => 'required_if:payment_method,transfer|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_method' => 'required|in:transfer,cod,dana,shopeepay,gopay,ovo',
        ]);

        $order = Order::findOrFail($orderId);

        // Ensure the order belongs to the authenticated user
        if ($order->id_user !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access to order.');
        }

        $payment = Payment::where('id_order', $orderId)->firstOrFail();

        // Handle file upload for transfer payment
        if ($request->payment_method === 'transfer' && $request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('payment_proofs', $fileName, 'public');

            $payment->payment_document = $filePath;
        }

        // Update payment status
        if ($request->payment_method === 'cod') {
            $payment->payment_status = 'unpaid'; // Will be paid on delivery
        } else {
            $payment->payment_status = 'paid';
            $payment->payment_date = now();
        }

        $payment->save();

        // Update order status
        $order->order_status = 'processing'; // Order is now being processed
        $order->save();

        return redirect()->route('customer.payment.confirmation', $orderId);
    }

    /**
     * Show payment confirmation page
     */
    public function showConfirmation($orderId)
    {
        $order = Order::with(['details.product'])->findOrFail($orderId);
        $payment = Payment::where('id_order', $orderId)->firstOrFail();

        // Ensure the order belongs to the authenticated user
        if ($order->id_user !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized access to order.');
        }

        return view('Pages.visitor.payment_confirmation', compact('order', 'payment'));
    }

    /**
     * Show orders history
     */
    public function orderHistory()
    {
        $orders = Order::with(['details.product', 'payments'])
            ->where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Pages.Visitor.order_history', compact('orders'));
    }

    /**
     * Allow customer to cancel their order
     */
    public function cancelOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Ensure the order belongs to the authenticated user
        if ($order->id_user !== Auth::id()) {
            return redirect()->route('customer.orders.history')->with('error', 'Unauthorized access to order.');
        }

        // Only allow cancellation if order is pending or processing
        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return redirect()->route('customer.orders.history')->with('error', 'Order cannot be cancelled.');
        }

        $order->order_status = 'cancelled';
        $order->save();

        return redirect()->route('customer.orders.history')->with('success', 'Order cancelled successfully.');
    }
}
