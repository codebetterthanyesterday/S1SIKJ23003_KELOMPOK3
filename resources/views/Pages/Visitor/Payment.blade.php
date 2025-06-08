@extends('layout.app')

@section('title', 'Payment Method')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-4">Choose Payment Method</h1>
            <p class="text-gray-600">Order #{{ $order->id_order }} - Total:
                Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border">
            <div class="border-b px-6 py-4 bg-gray-50">
                <h2 class="text-lg font-semibold">Order Summary</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="space-y-3">
                    <p><span class="font-medium">Pickup Time:</span>
                        {{ \Carbon\Carbon::parse($order->pickedup_at)->format('d M Y, H:i') }}</p>

                    <div class="mt-4">
                        <h3 class="font-medium mb-2">Items:</h3>
                        <div class="divide-y">
                            @foreach ($order->details as $detail)
                                <div class="py-3 flex justify-between">
                                    <div>
                                        <p class="font-medium">{{ $detail->product->product_name }}</p>
                                        <p class="text-gray-600 text-sm">{{ $detail->quantity }} x
                                            Rp{{ number_format($detail->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="font-medium">
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
        </div>

        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden border">
            <div class="border-b px-6 py-4 bg-gray-50">
                <h2 class="text-lg font-semibold">Payment Methods</h2>
            </div>

            <form action="{{ route('customer.payment.method', $order->id_order) }}" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Bank Transfer Option -->
                        <div class="payment-option border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                            <input type="radio" name="payment_method" id="transfer" value="transfer"
                                class="hidden payment-radio">
                            <label for="transfer" class="flex items-start cursor-pointer">
                                <div class="bg-green-50 rounded-md p-3 mr-4">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">Bank Transfer</h3>
                                    <p class="text-gray-600">Transfer to our bank account manually</p>
                                </div>
                            </label>
                        </div>

                        <!-- Cash on Delivery Option -->
                        <div class="payment-option border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                            <input type="radio" name="payment_method" id="cod" value="cod"
                                class="hidden payment-radio">
                            <label for="cod" class="flex items-start cursor-pointer">
                                <div class="bg-yellow-50 rounded-md p-3 mr-4">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">Cash on Delivery</h3>
                                    <p class="text-gray-600">Pay when you receive your order</p>
                                </div>
                            </label>
                        </div>

                        <!-- DANA -->
                        <div class="payment-option border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                            <input type="radio" name="payment_method" id="dana" value="dana"
                                class="hidden payment-radio">
                            <label for="dana" class="flex items-start cursor-pointer">
                                <div class="bg-blue-50 rounded-md p-3 mr-4 flex items-center justify-center">
                                    <span class="text-blue-600 font-bold text-lg">DANA</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">DANA</h3>
                                    <p class="text-gray-600">Pay with your DANA account</p>
                                </div>
                            </label>
                        </div>

                        <!-- ShopeePay -->
                        <div class="payment-option border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                            <input type="radio" name="payment_method" id="shopeepay" value="shopeepay"
                                class="hidden payment-radio">
                            <label for="shopeepay" class="flex items-start cursor-pointer">
                                <div class="bg-orange-50 rounded-md p-3 mr-4 flex items-center justify-center">
                                    <span class="text-orange-600 font-bold text-lg">ShopeePay</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">ShopeePay</h3>
                                    <p class="text-gray-600">Pay with your ShopeePay account</p>
                                </div>
                            </label>
                        </div>

                        <!-- GoPay -->
                        <div class="payment-option border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                            <input type="radio" name="payment_method" id="gopay" value="gopay"
                                class="hidden payment-radio">
                            <label for="gopay" class="flex items-start cursor-pointer">
                                <div class="bg-green-50 rounded-md p-3 mr-4 flex items-center justify-center">
                                    <span class="text-green-600 font-bold text-lg">GoPay</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">GoPay</h3>
                                    <p class="text-gray-600">Pay with your GoPay account</p>
                                </div>
                            </label>
                        </div>

                        <!-- OVO -->
                        <div class="payment-option border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                            <input type="radio" name="payment_method" id="ovo" value="ovo"
                                class="hidden payment-radio">
                            <label for="ovo" class="flex items-start cursor-pointer">
                                <div class="bg-purple-50 rounded-md p-3 mr-4 flex items-center justify-center">
                                    <span class="text-purple-600 font-bold text-lg">OVO</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">OVO</h3>
                                    <p class="text-gray-600">Pay with your OVO account</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" id="continue-btn"
                            class="bg-green-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Continue to Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .payment-option.selected {
            border-color: #047857;
            background-color: #f0fdf4;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentOptions = document.querySelectorAll('.payment-option');
            const continueBtn = document.getElementById('continue-btn');

            paymentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    paymentOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Check the radio inside this option
                    const radio = this.querySelector('input[type="radio"]');
                    radio.checked = true;

                    // Enable the continue button
                    continueBtn.disabled = false;
                });
            });
        });
    </script>
@endsection
