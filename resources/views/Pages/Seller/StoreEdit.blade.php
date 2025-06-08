@extends('layout.app2')

@section('title', 'Edit Store')

@section('content')
    <div class="max-w-xl mx-auto my-10 bg-white shadow-lg rounded-lg p-8 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6">Edit Store</h2>

        @if ($errors->any())
            <div class="mb-4">
                <ul class="text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="edit-store-form" action="{{ route('seller.store.update', $store->id_store) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="store_name">Store Name</label>
                <input type="text" id="store_name" name="store_name" value="{{ old('store_name', $store->store_name) }}"
                    class="w-full border rounded p-2" required>
            </div>

            {{-- Store Logo --}}
            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Store Logo</label>
                <div id="drop-area-logo"
                    class="w-full h-40 flex items-center justify-center border-2 border-dashed border-gray-400 rounded-lg bg-gray-50 cursor-pointer relative transition hover:border-blue-400">
                    <input type="file" id="store_logo" name="store_logo"
                        class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    <div id="image-preview-logo" class="flex flex-col items-center justify-center w-full h-full">
                        @if ($store->store_logo)
                            <img src="{{ asset('storage/' . $store->store_logo) }}" alt="Store Logo" id="preview-img-logo"
                                class="w-32 h-32 object-cover rounded mb-2">
                        @else
                            <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7v4a1 1 0 001 1h3m10-5v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h8a2 2 0 012 2z" />
                            </svg>
                        @endif
                        <span class="text-gray-500 text-sm" id="preview-text-logo">
                            @if ($store->store_logo)
                                Click or drag to change image
                            @else
                                Click or drag image here to upload
                            @endif
                        </span>
                    </div>
                    <button id="remove-image-logo" type="button"
                        class="absolute top-2 right-2 bg-white border border-gray-300 text-gray-500 hover:text-red-600 rounded-full p-1 shadow hidden z-10"
                        title="Remove Image" style="line-height:0;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <small class="text-gray-500">Format: jpeg, png, jpg, gif. Max 2 MB.</small>
            </div>

            {{-- Store Banner --}}
            <div class="mb-6">
                <label class="block text-gray-700 mb-1">Store Banner</label>
                <div id="drop-area-banner"
                    class="w-full h-40 flex items-center justify-center border-2 border-dashed border-gray-400 rounded-lg bg-gray-50 cursor-pointer relative transition hover:border-blue-400">
                    <input type="file" id="store_banner" name="store_banner"
                        class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    <div id="image-preview-banner" class="flex flex-col items-center justify-center w-full h-full">
                        @if ($store->store_banner)
                            <img src="{{ asset('storage/' . $store->store_banner) }}" alt="Store Banner"
                                id="preview-img-banner" class="w-32 h-32 object-cover rounded mb-2">
                        @else
                            <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7v4a1 1 0 001 1h3m10-5v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h8a2 2 0 012 2z" />
                            </svg>
                        @endif
                        <span class="text-gray-500 text-sm" id="preview-text-banner">
                            @if ($store->store_banner)
                                Click or drag to change image
                            @else
                                Click or drag image here to upload
                            @endif
                        </span>
                    </div>
                    <button id="remove-image-banner" type="button"
                        class="absolute top-2 right-2 bg-white border border-gray-300 text-gray-500 hover:text-red-600 rounded-full p-1 shadow hidden z-10"
                        title="Remove Image" style="line-height:0;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <small class="text-gray-500">Format: jpeg, png, jpg, gif. Max 2 MB.</small>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="store_address">Address</label>
                <input type="text" id="store_address" name="store_address"
                    value="{{ old('store_address', $store->store_address) }}" class="w-full border rounded p-2">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-1" for="description">Description</label>
                <textarea id="description" name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $store->description) }}</textarea>
                <div class="mt-2">
                    <p class="text-xs text-gray-600 mb-1">Quick phrases:</p>
                    @php $phrases=['Trusted seller','Premium quality','Fast response','Secure packaging','Free returns']; @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach ($phrases as $phrase)
                            <button type="button"
                                class="quick-phrase px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition"
                                data-phrase="{{ $phrase }}">+ {{ $phrase }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-1" for="store_status">Store Status</label>
                <select name="store_status" id="store_status" class="w-full border rounded p-2" required>
                    <option value="active" {{ old('store_status', $store->store_status) === 'active' ? 'selected' : '' }}>
                        Active</option>
                    <option value="inactive"
                        {{ old('store_status', $store->store_status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition">
                    Update Store
                </button>
                <a href="{{ route('seller.store.show', $store->id_store) }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function setupImagePreview(dropAreaId, inputId, previewId, textId, removeBtnId) {
            const dropArea = document.getElementById(dropAreaId);
            const inputFile = document.getElementById(inputId);
            const imagePreview = document.getElementById(previewId);
            const previewText = document.getElementById(textId);
            const removeBtn = document.getElementById(removeBtnId);

            // Drag & Drop
            dropArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropArea.classList.add('border-blue-400', 'bg-blue-50');
            });
            dropArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropArea.classList.remove('border-blue-400', 'bg-blue-50');
            });
            dropArea.addEventListener('drop', function(e) {
                e.preventDefault();
                dropArea.classList.remove('border-blue-400', 'bg-blue-50');
                if (e.dataTransfer.files.length) {
                    inputFile.files = e.dataTransfer.files;
                    handlePreview(inputFile.files[0]);
                }
            });

            // File select
            inputFile.addEventListener('change', function() {
                if (inputFile.files.length) {
                    handlePreview(inputFile.files[0]);
                }
            });

            function handlePreview(file) {
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Remove img if exists
                        const oldImg = imagePreview.querySelector('img');
                        if (oldImg) oldImg.remove();

                        // Show new preview
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-32 h-32 object-cover rounded mb-2';
                        imagePreview.prepend(img);
                        previewText.textContent = 'Click or drag to change image';
                        removeBtn.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Remove image (reset preview)
            removeBtn.addEventListener('click', function() {
                inputFile.value = '';
                const oldImg = imagePreview.querySelector('img');
                if (oldImg) oldImg.remove();
                previewText.textContent = 'Click or drag image here to upload';
                removeBtn.classList.add('hidden');
            });

            // Show remove button if default image exists
            if (imagePreview.querySelector('img')) {
                removeBtn.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupImagePreview(
                'drop-area-logo', 'store_logo', 'image-preview-logo', 'preview-text-logo', 'remove-image-logo'
            );
            setupImagePreview(
                'drop-area-banner', 'store_banner', 'image-preview-banner', 'preview-text-banner',
                'remove-image-banner'
            );
        });

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
    </script>
@endsection
