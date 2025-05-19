@extends('layout.app2')

@section('title', 'Product Creation')

@section('content')
    <form action="" method="post" class="bg-[#fbfbfb] w-full p-8 rounded-lg shadow-md border-[1px] border-[lightgray] mt-10">
        @csrf
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-center">Product Info</h2>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900">Product Name</label>
                <input type="text" id="product_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    placeholder="John" required />
            </div>
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                <input type="text" id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    required />
            </div>
            <div>
                <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
                <input type="text" id="quantity"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    placeholder="Flowbite" required />
            </div>
            <div>
                <label for="product_image" class="block mb-2 text-sm font-medium text-gray-900">Product Image</label>
                <div class="flex flex-wrap items-center gap-4">
                    <!-- Placeholder -->
                    <div
                        class="w-20 h-20 border-2 border-dashed border-gray-400 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="m21.96,7.74s-.02-.05-.03-.07c-.02-.06-.04-.11-.07-.17-.02-.03-.04-.05-.06-.08-.03-.04-.06-.09-.1-.13-.03-.03-.06-.04-.08-.07-.04-.03-.07-.06-.11-.09,0,0,0,0-.01,0,0,0,0,0,0,0L12.49,2.13c-.3-.17-.67-.17-.97,0L2.58,7.1s-.06.02-.09.04c-.31.18-.49.51-.49.86v8c0,.36.2.7.51.87l9,5s.1.04.14.06c.03.01.06.03.09.03.08.02.17.03.25.03s.17-.01.25-.03c.03,0,.06-.02.09-.03.05-.02.1-.03.14-.06l9-5c.32-.18.51-.51.51-.87v-8c0-.09-.01-.18-.04-.26Zm-9.96-3.59l6.94,3.86-2.24,1.25-6.84-3.91,2.14-1.19Zm0,7.71l-6.92-3.86,2.74-1.52,6.84,3.91-2.65,1.47Zm8,3.56l-7,3.89v-5.71l3-1.67v3.08l2-1v-3.19l2-1.11v5.71Z">
                            </path>
                        </svg>
                    </div>

                    <!-- Upload Button -->
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-purple-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        Upload photo
                    </button>

                    <!-- Delete Button -->
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-red-500 text-red-500 hover:bg-red-50 font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-red-200">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        <div class="mb-6">
            <label for="product_description" class="block mb-2 text-sm font-medium text-gray-900">Product Description</label>
            <textarea name="product_description" id="product_description" cols="30" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"></textarea>
        </div>
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Choose Category</h2>
            <div class="max-w-3xl mx-auto grid lg:grid-cols-4 md:grid-cols-2 gap-6 px-4">
                <!-- Gourmet Entrées -->
                <button
                    class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex flex-col items-center text-center focus:outline-none focus:ring-4 focus:ring-green-200">
                    <span class="text-green-600 mb-2 text-3xl">🍽️</span>
                    <span class="font-semibold">Gourmet Entrées</span>
                </button>
                <!-- Petite Pleasures -->
                <button
                    class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex flex-col items-center text-center focus:outline-none focus:ring-4 focus:ring-pink-200">
                    <span class="text-pink-600 mb-2 text-3xl">🍰</span>
                    <span class="font-semibold">Petite Pleasures</span>
                </button>
                <!-- Refined Refreshments -->
                <button
                    class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex flex-col items-center text-center focus:outline-none focus:ring-4 focus:ring-teal-200">
                    <span class="text-teal-600 mb-2 text-3xl">🍹</span>
                    <span class="font-semibold">Refined Refreshments</span>
                </button>
                <!-- Harvest Elegance -->
                <button
                    class="bg-white p-6 rounded-xl shadow hover:shadow-xl transition flex flex-col items-center text-center focus:outline-none focus:ring-4 focus:ring-green-200">
                    <span class="text-green-600 mb-2 text-3xl">🥗</span>
                    <span class="font-semibold">Harvest Elegance</span>
                </button>
            </div>
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
    </form>
@endsection
