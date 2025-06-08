@extends('layout.app')

@section('title', $store->store_name ?? 'Store')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden border mb-8">
            <div class="relative h-48 bg-gray-200 overflow-hidden">
                @if ($store->store_banner)
                    <img src="{{ asset('storage/store_banners/' . $store->store_banner) }}" alt="{{ $store->store_name }}"
                        class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-green-400 to-blue-500"></div>
                @endif

                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/60 to-transparent">
                    <h1 class="text-white text-3xl font-bold">{{ $store->store_name }}</h1>
                </div>
            </div>

            <div class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-full border-4 border-white shadow-md overflow-hidden bg-white">
                        @if ($store->store_logo)
                            <img src="{{ asset('storage/store_logos/' . $store->store_logo) }}"
                                alt="{{ $store->store_name }} logo" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="text-gray-600">{{ $store->store_address }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h2 class="text-xl font-semibold mb-2">About this store</h2>
                    <p class="text-gray-700">{{ $store->store_description ?: 'No description available.' }}</p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-4">Products</h2>
        </div>

        @if ($store->products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($store->products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border hover:shadow-lg transition">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <div class="h-48 bg-gray-100">
                                @if ($product->product_image)
                                    <img src="{{ asset('storage/product_images/' . $product->product_image) }}"
                                        alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-medium text-gray-900">{{ $product->product_name }}</h3>
                                <p class="text-green-600 font-bold mt-1">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                        <div class="px-4 pb-4">
                            <form action="{{ route('customer.cart.add', $product->id_product) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg border">
                <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4">
                    </path>
                </svg>
                <p class="text-xl font-medium mt-4">No products available in this store</p>
                <p class="text-gray-500 mt-2">Check back later for new products</p>
            </div>
        @endif
    </div>
@endsection
