@extends('layout.app')

@section('title', 'Payment Confirmation')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden border">
            <div class="bg-green-50 p-8 text-center border-b">
                <div class="flex justify-center mb-4">
                    <svg class="w-20 h-20 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-green-800 mb-2">Order Confirmed!</h1>
                <p class="text-lg text-green-700">
                    @if ($payment->payment_status === 'paid')
                        Your payment has been received.
                    @elseif($payment->method === 'cod')
                        Your order is confirmed for Cash on Delivery.
                    @else
                        Your order is being processed.
                    @endif
                </p>
            </div>

            <div class="p-6 md:p-8">
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Order Number</p>
                            <p class="font-medium">#{{ $order->id_order }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Order Date</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Payment Method</p>
                            <p class="font-medium">{{ ucfirst($payment->method) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Payment Status</p>
                            <p class="font-medium">
                                @if ($payment->payment_status === 'paid')
                                    <span class="text-green-600">Paid</span>
                                @elseif($payment->method === 'cod')
                                    <span class="text-orange-600">Pay on Delivery</span>
                                @else
                                    <span class="text-yellow-600">Processing</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">Pickup Time</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($order->pickedup_at)->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Amount</p>
                            <p class="font-bold text-green-700">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Items</h2>
                    <div class="border rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Product</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($order->details as $detail)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium">{{ $detail->product->product_name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $detail->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            Rp{{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-right font-semibold">Total</td>
                                    <td class="px-6 py-4 font-bold text-green-700">
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="text-center space-y-4">
                    <p class="text-gray-600">Thank you for your order! We'll notify you when your order is ready for pickup.
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('home') }}"
                            class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">Continue
                            Shopping</a>
                        <a href="{{ route('customer.orders.history') }}"
                            class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">View
                            All Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
