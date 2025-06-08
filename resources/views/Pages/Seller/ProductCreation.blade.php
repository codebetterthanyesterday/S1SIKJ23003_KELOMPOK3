@extends('layout.app2')

@section('title', 'Product Creation')

@section('content')
    @if ($errors->any())
        <div class="mb-4">
            <ul class="text-red-600 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="product-form" action="{{ route('seller.product.store') }}" method="post" enctype="multipart/form-data"
        class="bg-[#fbfbfb] w-full p-8 rounded-lg shadow-md border-[1px] border-[lightgray] my-10">
        @csrf
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-center">Product Info</h2>
        </div>
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900">Product Name</label>
                <input type="text" id="product_name" name="product_name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"
                    placeholder="Ayam Bakar" required />
            </div>
            <div>
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                    <input type="text" id="price" name="price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 pl-10 pr-16"
                        required autocomplete="off" inputmode="numeric" pattern="[0-9,\.]*" />
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">.00</span>
                </div>
                <small class="text-gray-500">Only numbers allowed</small>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const priceInput = document.getElementById('price');
                    priceInput.addEventListener('input', function(e) {
                        let value = this.value.replace(/[^\d.,]/g, '');
                        value = value.replace(/\./g, '').replace(/,/g, '');
                        if (value) {
                            value = parseInt(value, 10).toLocaleString('id-ID');
                        }
                        this.value = value;
                    });
                });
            </script>
            <div>
                <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">Quantity</label>
                <div class="flex items-center">
                    <button type="button" id="decrement-qty"
                        class="px-3 py-1 bg-gray-200 rounded-l-lg text-gray-700 hover:bg-gray-300 focus:outline-none">-</button>
                    <input type="number" id="stock" name="stock" min="1" value="1"
                        class="bg-gray-50 border-t border-b border-gray-300 text-gray-900 text-sm w-20 text-center focus:ring-green-500 focus:border-green-500 p-2.5 outline-none no-spinner"
                        required />
                    <button type="button" id="increment-qty"
                        class="px-3 py-1 bg-gray-200 rounded-r-lg text-gray-700 hover:bg-gray-300 focus:outline-none">+</button>
                </div>
                <style>
                    input[type=number].no-spinner::-webkit-inner-spin-button,
                    input[type=number].no-spinner::-webkit-outer-spin-button {
                        -webkit-appearance: none;
                        margin: 0;
                    }

                    input[type=number].no-spinner {
                        -moz-appearance: textfield;
                    }
                </style>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const qtyInput = document.getElementById('stock');
                    const decBtn = document.getElementById('decrement-qty');
                    const incBtn = document.getElementById('increment-qty');

                    decBtn.addEventListener('click', function() {
                        let val = parseInt(qtyInput.value, 10) || 1;
                        if (val > 1) qtyInput.value = val - 1;
                    });
                    incBtn.addEventListener('click', function() {
                        let val = parseInt(qtyInput.value, 10) || 1;
                        qtyInput.value = val + 1;
                    });
                    qtyInput.addEventListener('input', function() {
                        if (this.value === '' || parseInt(this.value, 10) < 1) {
                            this.value = 1;
                        }
                    });
                });
            </script>
            <div>
                <label for="product_image" class="block mb-2 text-sm font-medium text-gray-900">Product Image</label>
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
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const fileInput = document.getElementById('product_image');
                    const previewImg = document.getElementById('preview-image');
                    const defaultIcon = document.getElementById('default-icon');
                    const removeBtn = document.getElementById('remove-image');

                    fileInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                previewImg.src = ev.target.result;
                                previewImg.classList.remove('hidden');
                                removeBtn.classList.remove('hidden');
                                defaultIcon.classList.add('hidden');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewImg.classList.add('hidden');
                            previewImg.src = '';
                            removeBtn.classList.add('hidden');
                            defaultIcon.classList.remove('hidden');
                        }
                    });

                    removeBtn.addEventListener('click', function() {
                        fileInput.value = '';
                        previewImg.classList.add('hidden');
                        previewImg.src = '';
                        removeBtn.classList.add('hidden');
                        defaultIcon.classList.remove('hidden');
                    });

                    // For clearing form: also clear image preview
                    window.clearImagePreview = function() {
                        fileInput.value = '';
                        previewImg.classList.add('hidden');
                        previewImg.src = '';
                        removeBtn.classList.add('hidden');
                        defaultIcon.classList.remove('hidden');
                    };
                });
            </script>
        </div>
        <div class="mb-6">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Product Description</label>
            <div class="relative">
                <textarea name="description" id="description" cols="30" rows="5"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 resize-y transition"
                    maxlength="500" placeholder="Describe your product (features, ingredients, etc.)"></textarea>
                <span id="desc-count" class="absolute bottom-2 right-4 text-xs text-gray-500">0 / 500</span>
            </div>
            <div class="flex gap-2 mt-2">
                <button type="button" class="px-3 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200"
                    onclick="insertDescSnippet('Fresh & high quality')">+ Fresh &amp; high quality</button>
                <button type="button" class="px-3 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200"
                    onclick="insertDescSnippet('Halal certified')">+ Halal certified</button>
                <button type="button" class="px-3 py-1 bg-purple-100 text-purple-700 rounded hover:bg-purple-200"
                    onclick="insertDescSnippet('Ready stock')">+ Ready stock</button>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const desc = document.getElementById('description');
                const count = document.getElementById('desc-count');

                function updateCount() {
                    count.textContent = `${desc.value.length} / 500`;
                }
                desc.addEventListener('input', updateCount);
                updateCount();
                window.insertDescSnippet = function(text) {
                    const start = desc.selectionStart;
                    const end = desc.selectionEnd;
                    const before = desc.value.substring(0, start);
                    const after = desc.value.substring(end);
                    let insert = text;
                    if (before && !before.endsWith('\n') && before.length > 0) insert = '\n' + insert;
                    desc.value = before + insert + after;
                    desc.focus();
                    desc.selectionStart = desc.selectionEnd = before.length + insert.length;
                    updateCount();
                }
            });
        </script>
        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Choose Category</h2>
            <div class="max-w-3xl mx-auto flex flex-wrap justify-center gap-6 px-4" id="category-flex">
                @foreach ($categories as $category)
                    <label
                        class="relative flex flex-col items-center cursor-pointer group category-label transition-all duration-200">
                        <input type="radio" name="id_category" value="{{ $category->id_category }}"
                            class="category-radio hidden" required>
                        <div
                            class="w-32 h-32 rounded-lg overflow-hidden border-2 border-gray-300 transition-all duration-200 relative flex items-center justify-center bg-white shadow-sm group-hover:scale-105 group-hover:shadow-lg">
                            <svg class="w-16 h-16 text-gray-500 transition-all duration-200 group-hover:brightness-75" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 4h7v7H3zM14 4h7v7h-7zM3 13h7v7H3zM14 13h7v7h-7z"/>
                            </svg>
                            <div
                                class="absolute inset-0 bg-[rgba(0,0,0,0.5)] group-hover:bg-[rgba(0,0,0,0.7)] flex items-center justify-center transition-all duration-200 pointer-events-none">
                                <span
                                    class="text-white font-semibold text-lg text-center px-2 drop-shadow">{{ $category->category_name }}</span>
                            </div>
                            <span
                                class="check-icon absolute top-2 right-2 z-10 bg-white rounded-full p-1 shadow-lg hidden transition-all duration-200">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                        </div>
                    </label>
                @endforeach
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radios = document.querySelectorAll('.category-radio');
                const labels = document.querySelectorAll('.category-label');

                function updateCheckIcons() {
                    labels.forEach(label => {
                        const radio = label.querySelector('.category-radio');
                        const icon = label.querySelector('.check-icon');
                        const box = label.querySelector('div');
                        if (radio.checked) {
                            icon.classList.remove('hidden');
                            box.classList.remove('border-gray-300');
                            box.classList.add('border-green-600', 'ring-2', 'ring-green-200', 'scale-105',
                                'shadow-lg');
                        } else {
                            icon.classList.add('hidden');
                            box.classList.add('border-gray-300');
                            box.classList.remove('border-green-600', 'ring-2', 'ring-green-200', 'scale-105',
                                'shadow-lg');
                        }
                    });
                }
                updateCheckIcons();
                radios.forEach(radio => {
                    radio.addEventListener('change', updateCheckIcons);
                });

                labels.forEach(label => {
                    label.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            const radio = label.querySelector('.category-radio');
                            radio.checked = true;
                            radio.dispatchEvent(new Event('change'));
                        }
                    });
                    label.setAttribute('tabindex', '0');
                });
            });
        </script>

        <div class="mb-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Choose Store</h2>
            <div class="max-w-3xl mx-auto flex flex-wrap justify-center gap-6 px-4" id="store-flex">
                @foreach ($stores as $store)
                    <label
                        class="relative flex items-center p-4 rounded-xl border-2 border-gray-300 transition cursor-pointer store-label group bg-white shadow hover:shadow-lg min-w-[270px] max-w-xs">
                        <input type="radio" name="id_store" value="{{ $store->id_store }}" class="store-radio hidden"
                            required>
                        <img src="{{ asset('storage/store_logos/' . $store->store_logo) }}" alt="{{ $store->store_name }}"
                            class="w-14 h-14 object-cover rounded-full border-2 border-gray-200 mr-4 shadow">
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-base text-gray-800 truncate">{{ $store->store_name }}</div>
                            <div class="text-gray-500 text-sm truncate">
                                {{ $store->store_address ?? '' }}
                            </div>
                        </div>
                        <span
                            class="store-check-icon absolute top-3 left-3 bg-white rounded-full p-1 shadow-lg border-2 border-green-600 hidden">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const radios = document.querySelectorAll('.store-radio');
                const labels = document.querySelectorAll('.store-label');

                function updateCheckIcons() {
                    labels.forEach(label => {
                        const radio = label.querySelector('.store-radio');
                        const icon = label.querySelector('.store-check-icon');
                        if (radio.checked) {
                            icon.classList.remove('hidden');
                            label.classList.remove('border-gray-300');
                            label.classList.add('border-green-600', 'ring-2', 'ring-green-200');
                        } else {
                            icon.classList.add('hidden');
                            label.classList.add('border-gray-300');
                            label.classList.remove('border-green-600', 'ring-2', 'ring-green-200');
                        }
                    });
                }
                updateCheckIcons();
                radios.forEach(radio => {
                    radio.addEventListener('change', updateCheckIcons);
                });
            });
        </script>

        <div class="flex gap-4 mt-8">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
            <button type="button" id="clear-form"
                class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center hidden">Clear</button>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('product-form');
                    const clearBtn = document.getElementById('clear-form');
                    const watchedFields = [
                        'product_name', 'price', 'stock', 'product_image', 'description'
                    ];

                    function hasValue() {
                        // Check text/number/textarea fields
                        for (const name of watchedFields) {
                            const el = form.elements[name];
                            if (!el) continue;
                            if (el.type === 'file') {
                                if (el.files && el.files.length > 0) return true;
                            } else if (el.value && el.value.trim() !== '' && el.value !== '1') {
                                return true;
                            }
                        }
                        // Check radio for category/store
                        if (form.querySelector('input[name="id_category"]:checked')) return true;
                        if (form.querySelector('input[name="id_store"]:checked')) return true;
                        return false;
                    }

                    function toggleClearBtn() {
                        if (hasValue()) {
                            clearBtn.classList.remove('hidden');
                        } else {
                            clearBtn.classList.add('hidden');
                        }
                    }

                    // Watch all relevant fields for changes
                    watchedFields.forEach(name => {
                        const el = form.elements[name];
                        if (el) {
                            el.addEventListener('input', toggleClearBtn);
                            if (el.type === 'file') {
                                el.addEventListener('change', toggleClearBtn);
                            }
                        }
                    });
                    // Watch radio buttons
                    form.querySelectorAll('input[name="id_category"], input[name="id_store"]').forEach(radio => {
                        radio.addEventListener('change', toggleClearBtn);
                    });

                    toggleClearBtn();
                });
            </script>
        </div>
    </form>

    <!-- SweetAlert2 CDN (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Clear form logic
            document.getElementById('clear-form').addEventListener('click', function() {
                Swal.fire({
                    title: 'Clear Form?',
                    text: 'All fields will be reset.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, clear it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('product-form');
                        form.reset();

                        // Clear image preview
                        if (window.clearImagePreview) window.clearImagePreview();

                        // Reset description count
                        const desc = document.getElementById('description');
                        const count = document.getElementById('desc-count');
                        if (desc && count) count.textContent = '0 / 500';

                        // Reset category/store check icons
                        document.querySelectorAll('.check-icon').forEach(e => e.classList.add(
                            'hidden'));
                        document.querySelectorAll('.category-label div').forEach(box => {
                            box.classList.add('border-gray-300');
                            box.classList.remove('border-green-600', 'ring-2',
                                'ring-green-200', 'scale-105', 'shadow-lg');
                        });
                        document.querySelectorAll('.store-check-icon').forEach(e => e.classList.add(
                            'hidden'));
                        document.querySelectorAll('.store-label').forEach(label => {
                            label.classList.add('border-gray-300');
                            label.classList.remove('border-green-600', 'ring-2',
                                'ring-green-200');
                        });
                    }
                });
            });

            // Submit confirmation logic
            document.getElementById('product-form').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Submit Product?',
                    text: 'Are you sure you want to submit this product?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, submit',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Optionally show loading
                        Swal.fire({
                            title: 'Submitting...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        // Actually submit the form
                        e.target.submit();
                    }
                });
            });
        });
    </script>
@endsection
