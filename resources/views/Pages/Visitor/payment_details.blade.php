@extends('layout.app')

@section('title', 'Payment Details')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-4">Complete Your Payment</h1>
            <p class="text-gray-600">Order #{{ $order->id_order }} - Total:
                Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Payment Instructions -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border">
                    <div class="border-b px-6 py-4 bg-gray-50">
                        <h2 class="text-lg font-semibold">
                            @if ($method == 'transfer')
                                Bank Transfer Details
                            @else
                                {{ ucfirst($method) }} Payment
                            @endif
                        </h2>
                    </div>
                    <div class="p-6">
                        @if ($method == 'transfer')
                            <div class="space-y-6">
                                <div>
                                    <h3 class="font-semibold mb-2">Bank Account Details</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg border">
                                        <p class="font-medium">Bank: BCA (Bank Central Asia)</p>
                                        <p class="font-medium">Account Number: 8730456712</p>
                                        <p class="font-medium">Account Name: PT Langsung PO Indonesia</p>
                                    </div>
                                </div>

                                <div>
                                    <h3 class="font-semibold mb-2">Instructions</h3>
                                    <ol class="list-decimal list-inside space-y-2 pl-2">
                                        <li>Transfer the exact amount: <span
                                                class="font-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        </li>
                                        <li>Use your order number as payment reference: <span
                                                class="font-bold">#{{ $order->id_order }}</span></li>
                                        <li>Take a screenshot or photo of your payment confirmation</li>
                                        <li>Upload the proof of payment below</li>
                                    </ol>
                                </div>

                                <form action="{{ route('customer.payment.confirm', $order->id_order) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="{{ $method }}">

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block mb-2 font-medium">Upload Payment Proof</label>
                                            <input type="file" name="payment_proof"
                                                accept="image/jpeg,image/png,image/jpg,application/pdf"
                                                class="w-full border border-gray-300 rounded-lg p-2" required>
                                            <p class="text-gray-500 text-sm mt-1">Accepted formats: JPG, JPEG, PNG, PDF (max
                                                2MB)</p>
                                        </div>

                                        <button type="submit"
                                            class="bg-green-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-green-700 w-full">
                                            Confirm Payment
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @elseif($method == 'dana')
                            <div class="text-center space-y-6">>
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <p class="text-lg font-bold">Amount:
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('customer.payment.confirm', $order->id_order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="{{ $method }}">
                                    <button type="submit"
                                        class="bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-blue-700 w-full">
                                        I've Completed the Payment
                                    </button>
                                </form>
                            </div>
                        @elseif($method == 'shopeepay')
                            <div class="text-center space-y-6">
                                <div class="bg-orange-50 p-4 rounded-lg">
                                    <p class="text-lg font-bold">Amount:
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('customer.payment.confirm', $order->id_order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="{{ $method }}">
                                    <button type="submit"
                                        class="bg-orange-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-orange-700 w-full">
                                        I've Completed the Payment
                                    </button>
                                </form>
                            </div>
                        @elseif($method == 'gopay')
                            <div class="text-center space-y-6">
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <p class="text-lg font-bold">Amount:
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('customer.payment.confirm', $order->id_order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="{{ $method }}">
                                    <button type="submit"
                                        class="bg-green-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-green-700 w-full">
                                        I've Completed the Payment
                                    </button>
                                </form>
                            </div>
                        @elseif($method == 'ovo')
                            <div class="text-center space-y-6">
                                <div class="bg-purple-50 p-4 rounded-lg">
                                    <p class="text-lg font-bold">Amount:
                                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('customer.payment.confirm', $order->id_order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="{{ $method }}">
                                    <button type="submit"
                                        class="bg-purple-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-purple-700 w-full">
                                        I've Completed the Payment
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div class="mt-8 text-center">
                            <p class="text-gray-500">Having trouble? <a href="#"
                                    class="text-green-600 font-medium">Contact our support</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden border sticky top-6">
                    <div class="border-b px-6 py-4 bg-gray-50">
                        <h2 class="text-lg font-semibold">Order Summary</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <p><span class="font-medium">Order #:</span> {{ $order->id_order }}</p>
                            <p><span class="font-medium">Pickup Time:</span>
                                {{ \Carbon\Carbon::parse($order->pickedup_at)->format('d M Y, H:i') }}</p>

                            <div class="mt-4 pt-4 border-t">
                                <h3 class="font-medium mb-2">Items:</h3>
                                <div class="divide-y">
                                    @foreach ($order->details as $detail)
                                        <div class="py-2 flex justify-between text-sm">
                                            <div>
                                                <p>{{ $detail->product->product_name }}</p>
                                                <p class="text-gray-600">{{ $detail->quantity }} x</p>
                                            </div>
                                            <div>
                                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="pt-4 flex justify-between font-bold">
                                <span>Total</span>
                                <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 text-center">
                        <a href="{{ route('customer.payment.show', $order->id_order) }}"
                            class="text-green-600 font-medium">Change payment method</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
