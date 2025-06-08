@extends('layout.app')

@section('title', 'Product')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div
            class="flex flex-col lg:flex-row gap-10 bg-gradient-to-br from-green-50 via-white to-blue-50 rounded-3xl shadow-2xl overflow-hidden border border-green-100">
            <!-- Product Image Gallery -->
            <div class="lg:w-2/5 flex flex-col items-center justify-center bg-gradient-to-b from-white to-green-50 p-10">
                <div class="relative w-full flex justify-center">
                    <img src="{{ $product->product_image ? asset('storage/product_images/' . $product->product_image) : 'https://via.placeholder.com/500x500?text=No+Image' }}"
                        alt="{{ $product->product_name }}"
                        class="w-full max-w-md h-auto object-contain rounded-2xl shadow-lg border-4 border-green-100 transition-transform duration-300 hover:scale-105" />
                </div>
            </div>
            <!-- Product Details -->
            <div class="lg:w-3/5 flex flex-col justify-between p-10">
                <div>
                    <h1 class="text-4xl font-extrabold text-green-800 mb-3 tracking-tight">{{ $product->product_name }}</h1>
                    <div class="flex flex-wrap items-center gap-3 mb-5">
                        <a href="{{ route('category.getproduct', $product->category->slug) }}"
                            class="inline-block bg-green-200 text-green-900 text-sm px-4 py-1 rounded-full font-semibold shadow hover:bg-green-300 transition">
                            {{ $product->category->category_name }}
                        </a>
                        <a href=""
                            class="inline-block bg-orange-200 text-orange-900 text-sm px-4 py-1 rounded-full font-semibold shadow hover:bg-orange-300 transition">
                            From <strong>{{ $product->store->store_name }}</strong>
                        </a>
                    </div>
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        {{ $product->description }}
                    </p>
                    <div class="flex items-center gap-6 mb-8">
                        <span
                            class="text-3xl font-extrabold text-green-600 drop-shadow">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-base text-gray-500 bg-gray-100 px-4 py-1 rounded-full">Stok: <span
                                class="font-bold text-green-700">{{ $product->stock }}</span></span>
                        <span class="text-xs text-gray-400">Terjual: {{ $sold > 99 ? '99+' : $sold }}</span>
                    </div>
                </div>
                <div>
                    <form id="add-to-cart-form" class="flex flex-col sm:flex-row items-center gap-5" method="POST"
                        action="{{ route('customer.cart.add', $product->id_product) }}">
                        @csrf
                        <label for="quantity" class="sr-only">Jumlah</label>
                        <div
                            class="flex items-center border-2 border-green-200 rounded-xl overflow-hidden shadow-sm bg-white">
                            <button type="button" id="decrement-btn"
                                class="px-4 py-2 text-xl text-green-700 hover:bg-green-50 focus:outline-none"
                                aria-label="Kurangi jumlah">
                                <p class="text-3xl">-</p>
                            </button>
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $product->stock }}"
                                value="1"
                                class="w-16 text-center border-0 focus:ring-0 text-xl font-bold text-green-800 bg-transparent"
                                aria-label="Jumlah produk" style="appearance: textfield; -moz-appearance: textfield;">
                            <button type="button" id="increment-btn"
                                class="px-4 py-2 text-xl text-green-700 hover:bg-green-50 focus:outline-none"
                                aria-label="Tambah jumlah">
                                <p class="text-3xl">+</p>
                            </button>
                        </div>
                        <button type="submit"
                            class="flex items-center gap-3 px-8 py-4 rounded-xl bg-gradient-to-r from-green-500 to-green-700 text-white font-bold text-lg shadow-lg hover:from-green-600 hover:to-green-800 transition transform hover:scale-105 active:scale-95"
                            id="add-to-cart-btn">
                            <i class="ri-shopping-cart-2-fill text-2xl"></i>
                            Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactivity: Quantity increment/decrement, Add to cart animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const incrementBtn = document.getElementById('increment-btn');
            const decrementBtn = document.getElementById('decrement-btn');
            const maxStock = parseInt(quantityInput.getAttribute('max')) || 1;

            incrementBtn.addEventListener('click', function() {
                let val = parseInt(quantityInput.value) || 1;
                if (val < maxStock) {
                    quantityInput.value = val + 1;
                }
            });

            decrementBtn.addEventListener('click', function() {
                let val = parseInt(quantityInput.value) || 1;
                if (val > 1) {
                    quantityInput.value = val - 1;
                }
            });

            // Optional: Add to cart animation
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            addToCartBtn?.addEventListener('click', function(e) {
                addToCartBtn.classList.add('scale-95', 'ring', 'ring-green-300');
                setTimeout(() => {
                    addToCartBtn.classList.remove('scale-95', 'ring', 'ring-green-300');
                }, 300);
            });
        });
    </script>
@endsection
