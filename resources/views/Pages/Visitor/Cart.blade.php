@extends('layout.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-8">Shopping Cart</h1>

        <div id="cart-items" class="space-y-6">
            @if (empty($cartStores))
                <div class="text-gray-400 text-center py-8" id="cart-empty-message">
                    <p class="text-xl mb-4">Your cart is empty</p>
                    <a href="{{ route('home') }}" class="text-green-600 hover:text-green-700 font-medium">Continue
                        Shopping</a>
                </div>
            @else
                @foreach ($cartStores as $store)
                    <div class="border rounded-lg shadow-sm bg-white overflow-hidden">
                        <div class="bg-gray-50 px-6 py-4 border-b">
                            <h2 class="font-bold text-lg text-green-700">{{ $store['storeName'] }}</h2>
                        </div>

                        <div class="divide-y">
                            @foreach ($store['products'] as $item)
                                <div class="p-6 flex items-center gap-6 cart-product-row"
                                    data-price="{{ $item['product_price'] }}" data-cart-item-id="{{ $item['cartItemID'] }}">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item['product_image'] }}" alt="{{ $item['product_name'] }}"
                                            class="w-24 h-24 rounded-lg object-cover border" />
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="font-medium text-lg mb-1">{{ $item['product_name'] }}</h3>
                                        <div class="text-green-600 font-bold mb-3">
                                            Rp{{ number_format($item['product_price'], 0, ',', '.') }}
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <button type="button"
                                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-lg font-bold hover:bg-gray-200 decrement-qty">-</button>
                                            <input type="number" min="1" value="{{ $item['quantity'] }}"
                                                class="inline-block w-16 text-center border rounded-lg py-1 focus:outline-none focus:ring-2 focus:ring-green-500 qty-input"
                                                style="appearance: textfield;" />
                                            <button type="button"
                                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-lg font-bold hover:bg-gray-200 increment-qty">+</button>
                                            <button class="text-red-500 hover:text-red-700 ml-4 remove-cart-item"
                                                data-cart-item-id="{{ $item['cartItemID'] }}">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 text-right">
                                        <div class="font-semibold text-lg text-green-600 product-total">
                                            Rp{{ number_format($item['product_price'] * $item['quantity'], 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center">
                            <span class="font-medium text-gray-700">Store Total:
                                <span class="font-bold text-green-600 store-total">
                                    Rp{{ number_format(
                                        array_sum(array_map(fn($item) => $item['product_price'] * $item['quantity'], $store['products'])),
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                </span>
                            </span>
                            <form action="{{ route('customer.checkout.store', $store['storeID']) }}" method="POST"
                                class="m-0">
                                @csrf
                                <div class="flex flex-col gap-2 mb-2">
                                    <label for="pickedup_at_{{ $store['storeID'] }}"
                                        class="font-medium text-sm text-gray-700">Pick Up Time</label>
                                    <input type="datetime-local" name="pickedup_at"
                                        id="pickedup_at_{{ $store['storeID'] }}" class="border rounded px-2 py-1 w-full"
                                        required>
                                </div>
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                                    Checkout Store
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <div class="mt-8 bg-white rounded-lg shadow-sm border p-6">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-medium text-gray-700">Total Cart Value</span>
                        <span id="cart-total" class="text-2xl font-bold text-green-600">
                            Rp{{ number_format(
                                array_sum(
                                    array_map(
                                        fn($store) => array_sum(
                                            array_map(fn($item) => $item['product_price'] * $item['quantity'], $store['products']),
                                        ),
                                        $cartStores,
                                    ),
                                ),
                                0,
                                ',',
                                '.',
                            ) }}
                        </span>
                    </div>
                    <div class="flex justify-center mt-6">
                        <a href="{{ route('home') }}"
                            class="px-6 py-3 border border-gray-300 rounded-lg text-center font-medium hover:bg-gray-50 transition">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function formatRupiah(num) {
            return 'Rp' + num.toLocaleString('id-ID');
        }

        document.addEventListener('DOMContentLoaded', function() {
            function recalculateCart() {
                let grandTotal = 0;
                document.querySelectorAll('.border.rounded-lg.shadow-sm.bg-white').forEach(function(storeBox) {
                    let storeTotal = 0;
                    storeBox.querySelectorAll('.cart-product-row').forEach(function(row) {
                        const price = parseInt(row.getAttribute('data-price')) || 0;
                        const qtyInput = row.querySelector('.qty-input');
                        const qty = parseInt(qtyInput.value) || 1;
                        const productTotal = price * qty;
                        row.querySelector('.product-total').textContent = formatRupiah(
                        productTotal);
                        storeTotal += productTotal;
                    });
                    const storeTotalSpan = storeBox.querySelector('.store-total');
                    if (storeTotalSpan) storeTotalSpan.textContent = formatRupiah(storeTotal);
                    grandTotal += storeTotal;
                });
                const cartTotal = document.getElementById('cart-total');
                if (cartTotal) cartTotal.textContent = formatRupiah(grandTotal);
            }

            // Function to update cart item quantity in database
            function updateCartItemQuantity(cartItemId, quantity) {
                fetch('/customer/cart/update', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            cart_item_id: cartItemId,
                            quantity: quantity
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Failed to update cart: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                    });
            }

            // Add debounce function to avoid too many requests
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Create debounced version of the update function
            const debouncedUpdate = debounce(updateCartItemQuantity, 500);

            document.getElementById('cart-items')?.addEventListener('click', function(e) {
                if (e.target.classList.contains('increment-qty') || e.target.classList.contains(
                        'decrement-qty')) {
                    const row = e.target.closest('.cart-product-row');
                    const input = row.querySelector('.qty-input');
                    const cartItemId = row.getAttribute('data-cart-item-id');

                    let qty = parseInt(input.value) || 1;
                    if (e.target.classList.contains('increment-qty')) {
                        qty++;
                    } else if (e.target.classList.contains('decrement-qty')) {
                        qty = Math.max(1, qty - 1);
                    }
                    input.value = qty;

                    // Update UI immediately for better UX
                    recalculateCart();

                    // Send update to server
                    debouncedUpdate(cartItemId, qty);
                }

                if (e.target.classList.contains('remove-cart-item')) {
                    const btn = e.target;
                    const cartItemId = btn.getAttribute('data-cart-item-id');
                    const row = btn.closest('.cart-product-row');
                    const storeBox = btn.closest('.border.rounded-lg.shadow-sm.bg-white');

                    if (!confirm('Remove this item from cart?')) return;

                    fetch(`/customer/cart/remove/${cartItemId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': '*',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                row.remove();
                                recalculateCart();

                                if (storeBox && storeBox.querySelectorAll('.cart-product-row')
                                    .length === 0) {
                                    storeBox.remove();
                                }

                                if (document.querySelectorAll('.cart-product-row').length === 0) {
                                    location.reload(); // Refresh to show empty cart message
                                }
                            } else {
                                alert('Failed to remove item from cart!');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Failed to remove item from cart!');
                        });
                }
            });

            document.getElementById('cart-items')?.addEventListener('input', function(e) {
                if (e.target.classList.contains('qty-input')) {
                    const row = e.target.closest('.cart-product-row');
                    const cartItemId = row.getAttribute('data-cart-item-id');

                    let val = parseInt(e.target.value) || 1;
                    if (val < 1) val = 1;
                    e.target.value = val;

                    // Update UI immediately for better UX
                    recalculateCart();

                    // Send update to server
                    debouncedUpdate(cartItemId, val);
                }
            });

            // Initial calculation
            recalculateCart();
        });
    </script>
@endsection
