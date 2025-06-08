@extends('layout.app2')

@section('title', 'Product Detail')

@section('content')
<div class="max-w-3xl mx-auto my-10 bg-white shadow-lg rounded-lg p-8 border border-gray-200">
    <div class="flex flex-col md:flex-row gap-8">
        {{-- Gambar produk --}}
        <div class="flex-shrink-0 flex items-center justify-center">
            @if ($product->product_image)
                @php
                    $imagePath = 'storage/product_images/' . $product->product_image;
                @endphp
                <img src="{{ file_exists(public_path($imagePath)) ? asset($imagePath) : asset('img/placeholder.png') }}" alt="{{ $product->product_name }}"
                     class="w-52 h-52 object-cover rounded-xl border">
            @else
                <div class="w-52 h-52 flex items-center justify-center bg-gray-100 rounded-xl text-gray-400">
                    <span class="text-4xl">No Image</span>
                </div>
            @endif
        </div>
        {{-- Info produk --}}
        <div class="flex-1">
            <h2 class="text-3xl font-bold mb-2 text-gray-800">{{ $product->product_name }}</h2>
            <div class="mb-3 text-sm text-gray-500">
                <span class="inline-block bg-green-50 text-green-700 px-3 py-1 rounded-full mr-2">
                    {{ $product->category->category_name ?? 'No Category' }}
                </span>
                <span class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full">
                    {{ $product->store->store_name ?? 'No Store' }}
                </span>
            </div>
            <div class="text-2xl text-green-600 font-bold mb-2">
                Rp{{ number_format($product->price, 0, ',', '.') }}
            </div>
            <div class="mb-2">
                <span class="font-semibold text-gray-700">Stock:</span>
                <span>{{ $product->stock }}</span>
            </div>
            <div class="mb-2">
                <span class="font-semibold text-gray-700">Description:</span>
                <div class="text-gray-600 mt-1 whitespace-pre-line">
                    {{ $product->description ?? '-' }}
                </div>
            </div>
            <div class="mt-6 flex gap-2">
                <a href="{{ route('seller.product.edit', $product->id_product) }}"
                   class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded transition">Edit</a>
                <a href="{{ route('seller.products.list') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded transition">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
