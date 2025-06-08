@extends('layout.app2')

@section('title', 'Store Creation')

@section('content')
    @php $maxReached = $maxReached ?? false; @endphp
    @if ($maxReached)
        <div class="w-full mx-auto my-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
            You have reached the maximum limit of 5 stores. Please delete an existing store before creating a new one.
        </div>
    @endif
    <form id="store-creation-form" action="{{ route('seller.store.creation.process') }}" enctype="multipart/form-data"
        method="post" class="bg-[#fbfbfb] w-full p-8 rounded-lg shadow-md border-[1px] border-[lightgray] my-10"
        @if ($maxReached) onsubmit="return false;" @endif>
        @csrf
        <div class="mb-6">
            <input type="file" hidden name="store_banner" id="store_banner2" accept="image/*"
                onchange="if(this.files[0] && this.files[0].size > 2 * 1024 * 1024){ Swal.fire('File too large', 'Please select an image up to 2MB.', 'error'); this.value=''; }">
            <label for="store_banner2" class="block mb-2 text-sm font-medium text-gray-900">Store Banner</label>
            <div id="drop-area"
                class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-white flex items-center justify-center min-h-[250px] transition-all duration-300 ease-in-out">
                <img id="preview-banner"
                    class="absolute inset-0 w-full h-full object-contain rounded-lg hidden z-10 transition-all duration-300" />
                <button type="button" id="remove-banner"
                    class="absolute top-3 right-3 z-20 bg-white border border-gray-200 text-gray-500 hover:text-red-600 rounded-full p-1 shadow hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div id="upload-ui" class="flex flex-col items-center w-full transition-all duration-300">
                    <p class="text-gray-500 mb-4">Choose a file with a size up to 2MB.</p>
                    <button type="button" id="upload-btn"
                        class="inline-flex items-center px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded transition mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        Drag &amp; Drop to Upload
                    </button>
                    <p class="text-gray-500 my-3">or</p>
                    <label role="button" for="store_banner2"
                        class="text-purple-500 cursor-pointer hover:underline font-medium">
                        Browse
                    </label>
                </div>
            </div>
        </div>

        <style>
            #drop-area.animated {
                border-color: #a78bfa !important;
                border-width: 4px;
                background-color: #f3e8ff;
                transform: scale(1.03);
                box-shadow: 0 0 0 4px #c4b5fd22;
                transition: all 0.3s cubic-bezier(.4, 0, .2, 1);
            }
        </style>

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <input type="file" name="store_logo" hidden id="store_logo2" accept="image/*">
            <div>
                <label for="store_logo2" class="block mb-2 text-sm font-medium text-gray-900">Store Logo</label>
                <div class="flex flex-wrap items-center gap-4">
                    <div id="logo-placeholder"
                        class="w-20 h-20 border-2 border-dashed border-gray-400 rounded-lg flex items-center justify-center overflow-hidden bg-gray-50 relative">
                        <svg id="logo-default-icon"
                            class="w-10 h-10 text-gray-500 absolute inset-0 m-auto pointer-events-none transition"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="m20,2H4c-1.1,0-2,.9-2,2v4c0,1.01.39,1.91,1,2.62v9.38c0,1.1.9,2,2,2h14c1.1,0,2-.9,2-2v-9.38c.61-.7,1-1.61,1-2.62v-4c0-1.1-.9-2-2-2Zm-12,6c0,1.1-.9,2-2,2s-2-.9-2-2v-4h4v4Zm2-4h4v4c0,1.1-.9,2-2,2s-2-.9-2-2v-4Zm5,16h-6v-5c0-.55.45-1,1-1h4c.55,0,1,.45,1,1v5Zm5-12c0,1.1-.9,2-2,2s-2-.9-2-2v-4h4v4Z" />
                        </svg>
                        <img id="logo-preview" class="hidden object-cover w-full h-full rounded-lg" alt="Logo Preview">
                        <button type="button" id="logo-remove"
                            class="absolute top-0 right-0 bg-white border border-gray-300 text-gray-500 hover:text-red-600 rounded-full p-0.5 shadow hidden z-10"
                            title="Remove Logo" style="line-height:0;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <button type="button" id="logo-upload-btn"
                        class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition focus:outline-none focus:ring-2 focus:ring-purple-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                        </svg>
                        Upload photo
                    </button>
                </div>
            </div>
            <div>
                <label for="store_name2" class="block mb-2 text-sm font-medium text-gray-900">Store Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-purple-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <input type="text" id="store_name2" name="store_name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg pl-10 pr-12 p-2.5 w-full focus:ring-purple-500 focus:border-purple-500 focus:shadow-md transition-all duration-200 ease-in-out"
                        placeholder="Enter a catchy store name..." required />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-xs text-purple-500 font-medium opacity-75">Make it memorable!</span>
                    </div>
                </div>
                <p class="mt-1.5 text-xs text-gray-500">A great store name helps customers remember you</p>
            </div>
        </div>
        <div class="mb-6">
            <label for="description2" class="block mb-2 text-sm font-medium text-gray-900 flex justify-between">
                <span>Store Description</span>
                <span class="text-gray-500 text-xs" id="char-counter">0/500 characters</span>
            </label>
            <div class="relative">
                <textarea name="description" id="description2"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-4 transition-all duration-200 min-h-[120px] focus:min-h-[180px] resize-y"
                    placeholder="Describe what makes your store special..." maxlength="500"></textarea>
                <div class="absolute bottom-3 right-3 flex gap-2">
                    <button type="button" id="tips-btn" class="text-purple-500 hover:text-purple-700 transition-colors"
                        title="Writing tips">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="mt-2 text-sm text-gray-500 hidden" id="writing-tips">
                <p class="font-medium text-purple-600 mb-1">Tips for a great description:</p>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Highlight what makes your store unique</li>
                    <li>Mention your specialties or signature products</li>
                    <li>Include your store's history or mission</li>
                </ul>
            </div>
            <div class="mt-3" id="quick-phrases">
                <p class="text-sm text-gray-600 mb-1">Quick phrases:</p>
                <div class="flex flex-wrap gap-2">
                    @php
                        $phrases = [
                            'High quality products',
                            'Fast shipping',
                            'Best price guaranteed',
                            'Excellent customer service',
                            'Limited stock',
                        ];
                    @endphp
                    @foreach ($phrases as $phrase)
                        <button type="button"
                            class="quick-phrase px-3 py-1 text-sm bg-purple-100 text-purple-700 rounded-full hover:bg-purple-200 transition"
                            data-phrase="{{ $phrase }}">+ {{ $phrase }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
            // Store description character counter
            const descriptionField = document.getElementById('description2');
            const charCounter = document.getElementById('char-counter');
            const tipsBtn = document.getElementById('tips-btn');
            const writingTips = document.getElementById('writing-tips');

            function updateCharCount() {
                const count = descriptionField.value.length;
                charCounter.textContent = `${count}/500 characters`;

                // Change color when getting close to limit
                if (count > 400) {
                    charCounter.classList.add('text-amber-500');
                    if (count > 450) {
                        charCounter.classList.add('text-red-500');
                        charCounter.classList.remove('text-amber-500');
                    }
                } else {
                    charCounter.classList.remove('text-amber-500', 'text-red-500');
                }
            }

            descriptionField.addEventListener('input', updateCharCount);

            // Toggle writing tips
            tipsBtn.addEventListener('click', () => {
                writingTips.classList.toggle('hidden');
            });

            // Auto-resize textarea as content grows
            descriptionField.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            // Initialize character counter
            updateCharCount();

            // JS insert phrase
            document.querySelectorAll('.quick-phrase').forEach(btn => {
                btn.addEventListener('click', () => {
                    const phrase = btn.dataset.phrase;
                    const textarea = descriptionField;
                    const startPos = textarea.selectionStart || 0;
                    const endPos = textarea.selectionEnd || 0;
                    const text = textarea.value;
                    const insert = (startPos !== endPos ? '' : (text && !text.endsWith(' ') ? ' ' : '')) +
                        phrase + ' ';
                    textarea.value = text.slice(0, startPos) + insert + text.slice(endPos);
                    textarea.focus();
                    textarea.selectionStart = textarea.selectionEnd = startPos + insert.length;
                    updateCharCount();
                    updateClearButton();
                });
            });
        </script>
        <div class="mb-6">
            <label for="store_address2" class="block mb-2 text-sm font-medium text-gray-900">Store Address</label>
            <textarea name="store_address" id="store_address2" cols="30" rows="5"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"
                placeholder="JL. Minangkabau"></textarea>
        </div>
        <div class="flex gap-4">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center @if ($maxReached) opacity-60 cursor-not-allowed @endif"
                @if ($maxReached) disabled @endif>Submit</button>
            <button type="button" id="clear-form-btn"
                class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center hidden">Clear</button>
        </div>
    </form>

    <!-- SweetAlert2 CDN (if not already included) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Banner logic
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('store_banner2');
        const preview = document.getElementById('preview-banner');
        const removeBtn = document.getElementById('remove-banner');
        const uploadBtn = document.getElementById('upload-btn');
        const uploadUI = document.getElementById('upload-ui');

        uploadBtn.addEventListener('click', () => fileInput.click());
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.add('animated');
            });
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                dropArea.classList.remove('animated');
            });
        });
        dropArea.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files && files[0]) {
                fileInput.files = files;
                showPreview(files[0]);
                updateClearButton();
            }
        });

        function showPreview(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    removeBtn.classList.remove('hidden');
                    uploadUI.classList.add('hidden');
                    updateClearButton();
                };
                reader.readAsDataURL(file);
            }
        }
        fileInput.addEventListener('change', e => {
            const file = fileInput.files[0];
            if (file) showPreview(file);
            updateClearButton();
        });
        removeBtn.addEventListener('click', () => {
            fileInput.value = '';
            preview.src = '';
            preview.classList.add('hidden');
            removeBtn.classList.add('hidden');
            uploadUI.classList.remove('hidden');
            updateClearButton();
        });

        // Logo logic
        const logoInput = document.getElementById('store_logo2');
        const logoPreview = document.getElementById('logo-preview');
        const logoDefaultIcon = document.getElementById('logo-default-icon');
        const logoRemove = document.getElementById('logo-remove');
        const logoUploadBtn = document.getElementById('logo-upload-btn');

        logoUploadBtn.addEventListener('click', () => logoInput.click());
        logoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreview.src = e.target.result;
                    logoPreview.classList.remove('hidden');
                    logoRemove.classList.remove('hidden');
                    logoDefaultIcon.classList.add('hidden');
                    updateClearButton();
                };
                reader.readAsDataURL(file);
            }
            updateClearButton();
        });
        logoRemove.addEventListener('click', function() {
            logoInput.value = '';
            logoPreview.src = '';
            logoPreview.classList.add('hidden');
            logoRemove.classList.add('hidden');
            logoDefaultIcon.classList.remove('hidden');
            updateClearButton();
        });

        // Inputs/fields for monitoring
        const storeNameInput = document.getElementById('store_name2');
        const descriptionInput = document.getElementById('description2');
        const addressInput = document.getElementById('store_address2');
        const clearBtn = document.getElementById('clear-form-btn');

        // Show/hide clear button if any field has value
        function updateClearButton() {
            let hasValue = false;

            // Check text fields
            if (storeNameInput.value.trim() !== '' ||
                descriptionInput.value.trim() !== '' ||
                addressInput.value.trim() !== '') {
                hasValue = true;
            }

            // Check file inputs
            if ((fileInput.files && fileInput.files.length > 0) ||
                (logoInput.files && logoInput.files.length > 0)) {
                hasValue = true;
            }

            // Check if banner preview is shown (in case file input is not reliable)
            if (!preview.classList.contains('hidden') && preview.src) {
                hasValue = true;
            }

            // Check if logo preview is shown
            if (!logoPreview.classList.contains('hidden') && logoPreview.src) {
                hasValue = true;
            }

            if (hasValue) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        // Listen to input events for text fields
        storeNameInput.addEventListener('input', updateClearButton);
        descriptionInput.addEventListener('input', updateClearButton);
        addressInput.addEventListener('input', updateClearButton);

        // Initial state
        updateClearButton();

        // Clear form logic
        clearBtn.addEventListener('click', function() {
            Swal.fire({
                title: 'Clear Form?',
                text: "All fields will be reset.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Reset form fields
                    document.getElementById('store-creation-form').reset();

                    // Reset banner preview
                    fileInput.value = '';
                    preview.src = '';
                    preview.classList.add('hidden');
                    removeBtn.classList.add('hidden');
                    uploadUI.classList.remove('hidden');

                    // Reset logo preview
                    logoInput.value = '';
                    logoPreview.src = '';
                    logoPreview.classList.add('hidden');
                    logoRemove.classList.add('hidden');
                    logoDefaultIcon.classList.remove('hidden');

                    updateClearButton();

                    Swal.fire('Cleared!', 'The form has been reset.', 'success');
                }
            });
        });

        // SweetAlert on submit
        document.getElementById('store-creation-form').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Submit Store?',
                text: "Are you sure all data is correct?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, submit!'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit();
                }
            });
        });
    </script>
@endsection
