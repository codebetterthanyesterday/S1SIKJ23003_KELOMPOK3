@extends('layout.app2')

@section('title', 'Edit Product')

@section('content')
    <div class="max-w-xl mx-auto my-10 bg-white shadow-lg rounded-lg p-8 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6">Edit Product</h2>
        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('seller.product.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name"
                    value="{{ old('product_name', $product->product_name) }}" class="w-full border rounded p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="price">Price</label>
                <input type="text" id="price" name="price"
                    value="{{ old('price', number_format($product->price, 0, '', '.')) }}" class="w-full border rounded p-2"
                    required>
                <small class="text-gray-500">Example: 10000 atau 10.000</small>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="stock">Stock</label>
                <div class="flex items-center">
                    <button type="button" id="dec-stock"
                        class="px-3 py-1 bg-gray-200 rounded-l-lg text-gray-700 hover:bg-gray-300 focus:outline-none">-</button>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                        class="border-t border-b border-gray-300 text-gray-900 text-sm w-24 text-center focus:ring-purple-500 focus:border-purple-500 p-2 no-spinner"
                        min="0" required />
                    <button type="button" id="inc-stock"
                        class="px-3 py-1 bg-gray-200 rounded-r-lg text-gray-700 hover:bg-gray-300 focus:outline-none">+</button>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="description">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
                <div class="mt-2">
                    <p class="text-xs text-gray-600 mb-1">Quick phrases:</p>
                    @php $phrases=['Top notch quality','Ready stock','Affordable price','Customer favorite','Fast delivery']; @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach ($phrases as $phrase)
                            <button type="button"
                                class="quick-phrase px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition"
                                data-phrase="{{ $phrase }}">+ {{ $phrase }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="id_category">Category</label>
                <select name="id_category" id="id_category" class="w-full border rounded p-2" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id_category }}"
                            {{ $product->id_category == $category->id_category ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="id_store">Store</label>
                <select name="id_store" id="id_store" class="w-full border rounded p-2" required>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id_store }}"
                            {{ $product->id_store == $store->id_store ? 'selected' : '' }}>
                            {{ $store->store_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-1" for="product_image">Product Image</label>
                <div class="flex flex-wrap items-center gap-4">
                    <div id="image-placeholder"
                        class="w-20 h-20 border-2 border-dashed border-gray-400 rounded-lg flex items-center justify-center overflow-hidden bg-gray-50 relative">
                        <svg id="default-icon"
                            class="w-10 h-10 text-gray-500 absolute inset-0 m-auto pointer-events-none transition"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="m21.96,7.74s-.02-.05-.03-.07c-.02-.06-.04-.11-.07-.17-.02-.03-.04-.05-.06-.08-.03-.04-.06-.09-.1-.13-.03-.03-.06-.04-.08-.07-.04-.03-.07-.06-.11-.09,0,0,0,0-.01,0,0,0,0,0,0,0L12.49,2.13c-.3-.17-.67-.17-.97,0L2.58,7.1s-.06.02-.09.04c-.31.18-.49.51-.49.86v8c0,.36.2.7.51.87l9,5s.1.04.14.06c.03.01.06.03.09.03.08.02.17.03.25.03s.17-.01.25-.03c.03,0,.06-.02.09-.03.05-.02.1-.03.14-.06l9-5c.32-.18.51-.51.51-.87v-8c0-.09-.01-.18-.04-.26Zm-9.96-3.59l6.94,3.86-2.24,1.25-6.84-3.91,2.14-1.19Zm0,7.71l-6.92-3.86,2.74-1.52,6.84,3.91-2.65,1.47Zm8,3.56l-7,3.89v-5.71l3-1.67v3.08l2-1v-3.19l2-1.11v5.71Z">
                            </path>
                        </svg>
                        <img id="preview-image" class="hidden object-cover w-full h-full rounded-lg" alt="Preview">
                        <button type="button" id="remove-image"
                            class="absolute top-0 right-0 bg-white border border-gray-300 text-gray-500 hover:text-red-600 rounded-full p-0.5 shadow hidden z-10"
                            title="Remove Image" style="line-height:0;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <label
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-purple-300 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        Upload photo
                        <input type="file" id="product_image" name="product_image" class="hidden" accept="image/*">
                    </label>
                </div>
                <small class="text-gray-500">Leave blank if you do not want to change the image</small>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                    Update
                </button>
                <a href="{{ route('seller.product.show', $product->id_product) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <style>
        input[type=number].no-spinner::-webkit-inner-spin-button,
        input[type=number].no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0
        }

        input[type=number].no-spinner {
            -moz-appearance: textfield
        }
    </style>
    <script>
        document.querySelectorAll('.quick-phrase').forEach(btn => {
            btn.addEventListener('click', () => {
                const phrase = btn.dataset.phrase;
                const ta = document.getElementById('description');
                const start = ta.selectionStart || 0;
                const end = ta.selectionEnd || 0;
                const txt = ta.value;
                const insert = (start !== end ? '' : (txt && !txt.endsWith(' ') ? ' ' : '')) + phrase + ' ';
                ta.value = txt.slice(0, start) + insert + txt.slice(end);
                ta.focus();
                ta.selectionStart = ta.selectionEnd = start + insert.length;
            });
        });

        // image preview logic
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('product_image');
            const previewImg = document.getElementById('preview-image');
            const defaultIcon = document.getElementById('default-icon');
            const removeBtn = document.getElementById('remove-image');
            const placeholder = document.getElementById('image-placeholder');

            // initial preview if existing image
            @if ($product->product_image)
                previewImg.src = '{{ asset('storage/product_images/' . $product->product_image) }}';
                previewImg.classList.remove('hidden');
                removeBtn.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
            @endif

            function showPreview(file) {
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.classList.remove('hidden');
                        removeBtn.classList.remove('hidden');
                        defaultIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }

            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    showPreview(this.files[0]);
                }
            });

            removeBtn.addEventListener('click', function() {
                fileInput.value = '';
                previewImg.src = '';
                previewImg.classList.add('hidden');
                removeBtn.classList.add('hidden');
                defaultIcon.classList.remove('hidden');
            });

            // drag over
            placeholder.addEventListener('dragover', function(e) {
                e.preventDefault();
                placeholder.classList.add('border-purple-400', 'bg-purple-50');
            });
            placeholder.addEventListener('dragleave', function(e) {
                e.preventDefault();
                placeholder.classList.remove('border-purple-400', 'bg-purple-50');
            });
            placeholder.addEventListener('drop', function(e) {
                e.preventDefault();
                placeholder.classList.remove('border-purple-400', 'bg-purple-50');
                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    const file = e.dataTransfer.files[0];
                    fileInput.files = e.dataTransfer.files;
                    showPreview(file);
                }
            });
        });

        // stock counter
        const dec = document.getElementById('dec-stock');
        const inc = document.getElementById('inc-stock');
        const stockInput = document.getElementById('stock');
        dec?.addEventListener('click', () => {
            let v = parseInt(stockInput.value) || 0;
            if (v > 0) stockInput.value = v - 1;
        });
        inc?.addEventListener('click', () => {
            let v = parseInt(stockInput.value) || 0;
            stockInput.value = v + 1;
        });
    </script>
@endpush
