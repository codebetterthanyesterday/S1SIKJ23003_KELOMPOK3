@extends('layout.app2')

@section('title', 'Store Detail')

@section('content')
    <div class="max-w-3xl mx-auto my-10 bg-white shadow-lg rounded-lg border border-gray-200 p-0">

        {{-- Store Banner --}}
        @if ($store->store_banner)
            @php
                $bannerPath = $store->store_banner ? 'storage/store_banners/' . $store->store_banner : null;
            @endphp
            <div class="w-full h-48 rounded-t-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                <img src="{{ $bannerPath && file_exists(public_path($bannerPath)) ? asset($bannerPath) : asset('img/placeholder.png') }}"
                    alt="Store Banner" class="object-cover w-full h-full">
            </div>
        @endif

        <div class="p-8 flex flex-col md:flex-row gap-8">
            {{-- Store Logo --}}
            <div class="flex-shrink-0 flex items-center justify-center">
                @if ($store->store_logo)
                    @php
                        $logoPath = $store->store_logo ? 'storage/store_logos/' . $store->store_logo : null;
                    @endphp
                    <img src="{{ $logoPath && file_exists(public_path($logoPath)) ? asset($logoPath) : asset('img/placeholder.png') }}"
                        alt="{{ $store->store_name }}" class="w-40 h-40 object-cover rounded-lg border shadow">
                @else
                    <div class="w-40 h-40 flex items-center justify-center bg-gray-100 rounded-lg text-gray-400 border">
                        <span class="text-4xl">No Logo</span>
                    </div>
                @endif
            </div>
            {{-- Info Toko --}}
            <div class="flex-1">
                <h2 class="text-3xl font-bold mb-2 text-gray-800">{{ $store->store_name }}</h2>
                <div class="mb-2">
                    <span class="font-semibold text-gray-700">Address:</span>
                    <span class="text-gray-600">{{ $store->store_address ?? '-' }}</span>
                </div>
                <div class="mb-6">
                    <span class="font-semibold text-gray-700">Store Status:</span>
                    @if ($store->store_status === 'active')
                        <span
                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full font-semibold text-sm ml-2">Active</span>
                    @else
                        <span
                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full font-semibold text-sm ml-2">Inactive</span>
                    @endif
                </div>
                <div class="mb-6">
                    <span class="font-semibold text-gray-700">Description:</span>
                    <div class="text-gray-600 mt-1 whitespace-pre-line">
                        {{ $store->description ?? '-' }}
                    </div>
                </div>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('seller.store.edit', $store->id_store) }}"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded transition">Edit
                        Store</a>
                    <a href="{{ route('seller.stores.list') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded transition">Back
                        to List</a>
                </div>
            </div>
        </div>

        @if ($store->products && $store->products->count())
            <div class="px-8 pb-8">
                <h3 class="text-xl font-bold mb-4">Products in this Store</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700 border border-gray-200 rounded-lg">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Product Name</th>
                                <th class="px-4 py-2">Category</th>
                                <th class="px-4 py-2">Price</th>
                                <th class="px-4 py-2">Stock</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($store->products as $product)
                                <tr class="border-t">
                                    <td class="px-4 py-2">{{ $product->product_name }}</td>
                                    <td class="px-4 py-2">{{ $product->category->category_name ?? '-' }}</td>
                                    <td class="px-4 py-2">Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $product->stock }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('seller.product.show', $product->id_product) }}"
                                            class="text-blue-600 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
@endsection
