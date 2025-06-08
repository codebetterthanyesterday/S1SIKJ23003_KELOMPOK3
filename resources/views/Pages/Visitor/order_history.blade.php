@extends('layout.app')

@section('title', 'Order History')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl font-bold">Order History</h1>
            <p class="text-gray-600">View and track all your orders</p>
        </div>

        @if ($orders->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-10 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                </div>
                <p class="text-xl mb-6">You haven't placed any orders yet</p>
                <a href="{{ route('home') }}"
                    class="bg-green-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-700 transition">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden border">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pickup Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Payment</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-medium">#{{ $order->id_order }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($order->pickedup_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($order->order_status === 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($order->order_status === 'processing')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Processing
                                            </span>
                                        @elseif($order->order_status === 'ready')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Ready for Pickup
                                            </span>
                                        @elseif($order->order_status === 'completed')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Completed
                                            </span>
                                        @elseif($order->order_status === 'cancelled')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($order->payments->isNotEmpty())
                                            @php $payment = $order->payments->first(); @endphp
                                            @if ($payment->payment_status === 'paid')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Paid ({{ ucfirst($payment->method) }})
                                                </span>
                                            @elseif($payment->payment_status === 'unpaid' && $payment->method === 'cod')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                    Cash on Delivery
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Unpaid
                                                </span>
                                            @endif
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                No Payment
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('customer.payment.confirmation', $order->id_order) }}"
                                            class="text-green-600 hover:text-green-900">View Details</a>
                                        @if (in_array($order->order_status, ['pending', 'processing']))
                                            <form action="{{ route('customer.orders.cancel', $order->id_order) }}"
                                                method="POST" style="display:inline-block; margin-left: 10px;">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to cancel this order?');">Cancel</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($orders->hasPages())
                    <div class="px-6 py-3 bg-gray-50 border-t">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection
