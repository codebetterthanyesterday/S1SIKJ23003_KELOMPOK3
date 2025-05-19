@extends('layout.app2')

@section('title', 'Store Creation')

@section('content')
    <form action="{{ route('store.creation.process') }}" enctype="multipart/form-data" method="post" class="bg-[#fbfbfb] w-full p-8 rounded-lg shadow-md border-[1px] border-[lightgray] mt-10">
        @csrf
        <div class="mb-6">
            <input type="file" hidden name="store_banner" id="store_banner2">
            <label for="store_banner2" class="block mb-2 text-sm font-medium text-gray-900">Store Banner</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-white">
                <p class="text-gray-500 mb-4">Choose a file with a size up to 2MB.</p>
                <button type="button"
                    class="inline-flex items-center px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    Drag &amp; Drop to Upload
                </button>
                <p class="text-gray-500 my-3">or</p>
                <label role="button" for="store_banner2" class="text-purple-500 cursor-pointer hover:underline font-medium">
                    Browse
                </label>
            </div>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <input type="file" name="store_logo" hidden id="store_logo2">
            <div>
                <label for="store_logo2" class="block mb-2 text-sm font-medium text-gray-900">Store Logo</label>
                <div class="flex flex-wrap items-center gap-4">
                    <div class="w-20 h-20 border-2 border-dashed border-gray-400 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path d="m20,2H4c-1.1,0-2,.9-2,2v4c0,1.01.39,1.91,1,2.62v9.38c0,1.1.9,2,2,2h14c1.1,0,2-.9,2-2v-9.38c.61-.7,1-1.61,1-2.62v-4c0-1.1-.9-2-2-2Zm-12,6c0,1.1-.9,2-2,2s-2-.9-2-2v-4h4v4Zm2-4h4v4c0,1.1-.9,2-2,2s-2-.9-2-2v-4Zm5,16h-6v-5c0-.55.45-1,1-1h4c.55,0,1,.45,1,1v5Zm5-12c0,1.1-.9,2-2,2s-2-.9-2-2v-4h4v4Z"></path>
                        </svg>
                    </div>
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-purple-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        Upload photo
                    </button>
                    <button type="button"
                        class="inline-flex items-center px-4 py-2 border border-red-500 text-red-500 hover:bg-red-50 font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-red-200">
                        Delete
                    </button>
                </div>
            </div>
            <div>
                <label for="store_name2" class="block mb-2 text-sm font-medium text-gray-900">Store Name</label>
                <input type="text" id="store_name2" name="store_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    placeholder="Ayam Bakar Hj. Somad" required />
            </div>
        </div>
        <div class="mb-6">
            <label for="description2" class="block mb-2 text-sm font-medium text-gray-900">Store Description</label>
            <textarea name="description" id="description2" cols="30" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Warung Ayam Bakar paling gaul dengan produk ayam bakar paling gurih"></textarea>
        </div>
        <div class="mb-6">
            <label for="store_address2" class="block mb-2 text-sm font-medium text-gray-900">Store Address</label>
            <textarea name="store_address" id="store_address2" cols="30" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="JL. Minangkabau"></textarea>
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
    </form>
@endsection
