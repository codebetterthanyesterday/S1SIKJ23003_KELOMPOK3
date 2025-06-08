@extends('layout.app3')

@section('title', 'Creation')

@section('content')
    <form action="{{ route('admin.creation.process', "{$entity}") }}" method="POST" enctype="multipart/form-data"
        id="user-form">
        @csrf
        @if ($entity === 'product-category')
            <div class="space-y-12">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900">{{ $title }}</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">{{ $description }}</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="col-span-full">
                            <label for="cover-photo" class="block text-sm/6 font-medium text-gray-900">Category
                                Banner</label>
                            <div id="file-upload-area"
                                class="relative w-full min-h-[200px] border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center p-8 bg-white transition cursor-pointer hover:border-green-400 overflow-hidden">
                                <!-- Input file (hidden) -->
                                <input type="file" id="file-input" name="image" class="hidden"
                                    accept="image/png,image/jpeg,image/gif,image/avif" />

                                <!-- Area upload (icon & instruksi) -->
                                <div id="file-drop-zone"
                                    class="flex flex-col items-center justify-center w-full h-full pointer-events-none">
                                    <svg class="mx-auto size-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" data-slot="icon">
                                        <path fill-rule="evenodd"
                                            d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>
                                        <span
                                            class="text-green-600 font-semibold pointer-events-auto underline cursor-pointer"
                                            id="browse-btn">Upload a file</span>
                                        <span class="text-gray-500"> or drag and drop</span>
                                    </span>
                                    <span class="text-xs text-gray-400 mt-1">PNG, JPG, GIF, AVIF up to 10MB</span>
                                </div>

                                <!-- Preview gambar, awalnya hidden -->
                                <div id="preview"
                                    class="absolute inset-0 w-full h-full flex items-center justify-center z-10 hidden cursor-pointer">
                                </div>
                                <!-- Tombol hapus gambar, awalnya hidden -->
                                <button id="remove-btn" type="button"
                                    class="hidden absolute top-3 right-3 bg-white/80 hover:bg-red-500 hover:text-white text-red-500 rounded-full p-2 shadow z-20"
                                    title="Hapus gambar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <!-- Notifikasi error, awalnya hidden -->
                                <div id="file-error"
                                    class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-red-500 text-white text-xs px-3 py-1 rounded shadow hidden z-20">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="category_name" class="block text-sm/6 font-medium text-gray-900">Category
                                Name</label>
                            <div class="mt-2">
                                <input id="category_name" placeholder="Enter category name" name="category_name"
                                    type="text" autocomplete="category_name" required
                                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-green-500 focus:border-green-500 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="category_description"
                                class="block text-sm/6 font-medium text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea id="category_description" placeholder="Enter category description" name="category_description" rows="4"
                                    class="block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-green-500 focus:border-green-500 sm:text-sm/6"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="reset" class="text-sm/6 font-semibold clear-form-btn text-gray-900">Clear</button>
                <button type="submit"
                    class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700">Save</button>
            </div>
        @elseif ($entity === 'user')
            <div class="space-y-10">
                <div>
                    <h2 class="text-base/7 font-semibold text-gray-900">{{ $title }}</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">{{ $description }}</p>
                </div>

                <!-- Import File Section -->
                <div class="border-b border-gray-900/10 pb-8">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6">
                        <div class="sm:col-span-4 w-full">
                            <label class="block text-sm font-medium text-gray-900 mb-2">Import Users (Excel/CSV)</label>
                            {{-- IMPORT USERS CARD --}}
                            <div class="flex flex-col items-start gap-2 max-w-sm w-full">
                                {{-- Tombol Import --}}
                                <label id="import-label" class="w-fit cursor-pointer">
                                    <input id="import_file" name="import_file" type="file" accept=".xls,.xlsx,.csv"
                                        class="hidden" />
                                    <span
                                        class="import-btn flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white cursor-pointer shadow font-semibold transition select-none">
                                        {{-- Excel Icon --}}
                                        <svg class="w-5 h-5 text-white" viewBox="0 0 32 32" fill="currentColor">
                                            <rect width="32" height="32" rx="6" fill="#21A366" />
                                            <path
                                                d="M22 8h-8a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2zm-4 15a1 1 0 0 1-1-1h2a1 1 0 0 1-1 1zm3-3h-6v-1h6zm0-2h-6v-1h6zm0-2h-6v-1h6zm0-2h-6v-1h6zm0-2h-6v-1h6zm-3 7a1 1 0 1 1-2 0h2z"
                                                fill="#fff" />
                                        </svg>
                                        Import Excel/CSV
                                    </span>
                                </label>
                                {{-- Info File & Remove --}}
                                <div id="import-file-info" class="flex items-center gap-2 mt-1 hidden">
                                    <span id="import-file-name"
                                        class="px-2 py-1 rounded bg-green-50 border border-green-200 text-green-800 text-xs font-medium truncate max-w-[160px]"></span>
                                    <button type="button" id="import-remove-btn"
                                        class="w-6 h-6 flex items-center justify-center rounded-full bg-red-100 hover:bg-red-500 text-red-500 hover:text-white transition"
                                        title="Remove file">
                                        &times;
                                    </button>
                                </div>
                                {{-- Link Download Template --}}
                                <div class="flex items-center gap-2 text-xs mt-1">
                                    <a href="{{ asset('template/users_import_template.xlsx') }}"
                                        class="text-green-700 underline hover:text-green-800 font-semibold transition"
                                        download>
                                        Download template Excel
                                    </a>
                                    <span class="text-gray-400">|</span>
                                    <span class="text-gray-500">Diterima: .xls, .xlsx, .csv</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Manual Form Section -->
                <div class="border-b border-gray-900/10 pb-12" id="manual-section">
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="choose_role" class="block text-sm/6 font-medium text-gray-900">Choose role</label>
                            <div class="mt-2">
                                <select id="choose_role" name="role"
                                    class="manual-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                                    <option value="">-- Pilih --</option>
                                    <option value="customer">Customer</option>
                                    <option value="seller">Seller</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="email_address" class="block text-sm/6 font-medium text-gray-900">Enter email
                                address</label>
                            <div class="mt-2">
                                <input id="email_address" placeholder="Enter email address" name="email_address"
                                    type="email" autocomplete="email_address"
                                    class="manual-input block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-green-500 focus:border-green-500 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="username" class="block text-sm/6 font-medium text-gray-900">Create
                                username</label>
                            <div class="mt-2">
                                <input id="username" placeholder="Enter username" name="username" type="text"
                                    autocomplete="username"
                                    class="manual-input block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-green-500 focus:border-green-500 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900">Create
                                password</label>
                            <div class="mt-2">
                                <input id="password" placeholder="Enter password" name="password" type="password"
                                    autocomplete="new-password"
                                    class="manual-input block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-green-500 focus:border-green-500 sm:text-sm/6">
                            </div>
                        </div>
                        <div class="sm:col-span-4">
                            <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Confirm
                                password</label>
                            <div class="mt-2">
                                <input id="password_confirmation" placeholder="Enter password confirmation"
                                    name="password_confirmation" type="password" autocomplete="new-password"
                                    class="manual-input block w-full rounded-md border border-gray-300 bg-white px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-green-500 focus:border-green-500 sm:text-sm/6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="reset" class="text-sm/6 font-semibold clear-form-btn text-gray-900">Clear</button>
                <button type="submit"
                    class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-700">Save</button>
            </div>
        @endif
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(function() {
            var $importFile = $('#import_file');
            var $importFileInfo = $('#import-file-info');
            var $importFileName = $('#import-file-name');
            var $importRemoveBtn = $('#import-remove-btn');
            var $importLabel = $('#import-label');
            var $importBtn = $('.import-btn');
            var $manualInputs = $('.manual-input');

            // Aktifkan/Nonaktifkan tombol import + style
            function setImportDisabled(state) {
                $importFile.prop('disabled', state);
                if (state) {
                    $importBtn
                        .removeClass('bg-green-600 hover:bg-green-700 text-white cursor-pointer')
                        .addClass('bg-gray-300 text-gray-400 opacity-60 cursor-not-allowed')
                        .attr('aria-disabled', 'true');
                    $importLabel.addClass('cursor-not-allowed').removeClass('cursor-pointer');
                } else {
                    $importBtn
                        .removeClass('bg-gray-300 text-gray-400 opacity-60 cursor-not-allowed')
                        .addClass('bg-green-600 hover:bg-green-700 text-white cursor-pointer')
                        .removeAttr('aria-disabled');
                    $importLabel.addClass('cursor-pointer').removeClass('cursor-not-allowed');
                }
            }

            // Prevent click on label if disabled
            $importLabel.on('click', function(e) {
                if ($importFile.prop('disabled')) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    return false;
                }
            });

            // Saat pilih file
            $importFile.on('change', function() {
                if (this.files && this.files.length > 0) {
                    $importFileName.text(this.files[0].name);
                    $importFileInfo.removeClass('hidden');
                    // Disable manual fields jika ada
                    $manualInputs.val('').prop('disabled', true).addClass('bg-gray-100 cursor-not-allowed');
                } else {
                    $importFileName.text('');
                    $importFileInfo.addClass('hidden');
                    $manualInputs.prop('disabled', false).removeClass('bg-gray-100 cursor-not-allowed');
                }
            });

            // Remove file
            $importRemoveBtn.on('click', function() {
                $importFile.val('');
                $importFileName.text('');
                $importFileInfo.addClass('hidden');
                $manualInputs.prop('disabled', false).removeClass('bg-gray-100 cursor-not-allowed');
                setImportDisabled(false);
            });

            // Disable import jika manual diisi
            $manualInputs.on('input', function() {
                let filled = false;
                $manualInputs.each(function() {
                    if ($(this).val().trim() !== "") filled = true;
                });
                if (filled) {
                    $importFile.val('');
                    $importFileName.text('');
                    $importFileInfo.addClass('hidden');
                    setImportDisabled(true);
                } else {
                    setImportDisabled(false);
                }
            });
        });
    </script>
@endsection
