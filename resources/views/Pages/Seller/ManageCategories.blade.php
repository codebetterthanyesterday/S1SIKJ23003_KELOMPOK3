@extends('layout.app2')

@section('title', 'Manage Categories')

@section('content')
    <div class="bg-white w-full p-8 rounded-xl shadow-sm border border-gray-100">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Categories Management</h1>
            <div class="flex justify-between items-center">
                <p class="text-gray-600">Manage product categories to better organize your inventory.</p>
                <a href="{{ route('seller.products') }}"
                    class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                    <i class="ri-arrow-left-line mr-1"></i> Back to Products
                </a>
            </div>
        </div>

        <!-- Categories List -->
        <div class="relative overflow-x-auto shadow-sm sm:rounded-lg border border-gray-200">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Category Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Products Count
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-all duration-150">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                <div class="flex items-center">
                                    @if ($category->category_image)
                                        <div class="w-8 h-8 rounded-full overflow-hidden mr-3">
                                            <img src="{{ '/storage/' . $category->category_image }}"
                                                alt="{{ $category->category_name }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="ri-price-tag-3-line text-blue-600"></i>
                                        </div>
                                    @endif
                                    <span>{{ $category->category_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="line-clamp-2">{{ $category->description ?: 'No description' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                    {{ $category->products->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('seller.products.filter', ['status' => 'all', 'category' => $category->id_category]) }}"
                                        class="p-1.5 bg-green-50 rounded-full text-green-600 hover:bg-green-100 transition-colors">
                                        <i class="ri-filter-line"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="bg-white border-b">
                            <td colspan="4" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 flex items-center justify-center rounded-full mb-3">
                                        <i class="ri-price-tag-3-line text-gray-300 text-2xl"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-700 mb-1">No categories found</h3>
                                    <p class="text-sm text-gray-500 mb-4">Contact an administrator to add product
                                        categories.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
