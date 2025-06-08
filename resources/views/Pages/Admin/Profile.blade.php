@extends('layout.app3')

@section('title', "{$getUser->username} Profile")

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <div class="py-8 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-xl max-w-sm w-full">
            <div class="bg-green-600 h-24 rounded-t-2xl relative"></div>
            <!-- Avatar: overlap -->
            <div class="flex flex-col items-center -mt-14 relative">
                <div
                    class="w-28 h-28 mb-3 rounded-full border-4 border-white shadow-md bg-white flex items-center justify-center overflow-hidden">
                    <img id="avatarPreview"
                        src="{{ $getUser->profile_picture ? asset('storage/profile_pictures/' . $getUser->profile_picture) : asset('img/blank-profile-picture.png') }}"
                        alt="User Avatar" class="object-cover w-28 h-28">
                </div>
                <!-- Change avatar trigger (hidden, demo only) -->
                <label
                    class="mt-2 cursor-pointer bg-green-50 text-green-600 text-xs py-1 px-3 rounded-full shadow-sm hover:bg-green-100 transition">
                    Change Avatar
                    <input type="file" class="hidden" accept="image/*" onchange="previewAvatar(event)">
                </label>
            </div>

            <!-- Profile Info -->
            <div class="px-6 pb-6 flex flex-col items-center">
                <h2 class="mt-3 text-xl font-bold text-gray-800">{{ $getUser->username }}</h2>
                <p class="text-gray-500 text-sm">{{ $getUser->email }}</p>
                <span
                    class="text-xs font-semibold bg-green-100 text-green-700 rounded-full px-3 py-1 mt-2">{{ Str::ucfirst($getUser->roles->pluck('role_name')->first()) }}</span>

                <!-- Change Password -->
                <button onclick="showChangePassword()"
                    class="w-full mt-6 py-2 bg-green-600 text-white rounded-xl shadow hover:bg-green-700 transition font-semibold">
                    Change Password
                </button>
            </div>
        </div>

        <!-- Change Password Modal -->
        <div id="modalPassword"
            class="fixed z-[999999] inset-0 flex items-center justify-center bg-black/40 transition-all duration-300 hidden">
            <form method="POST" action="{{ route('change.password', $getUser->id_user) }}"
                class="bg-white rounded-2xl shadow-xl w-full max-w-xs p-7 flex flex-col items-center animate-fade-in-up">
                @csrf
                @method('PUT')
                <h3 class="font-bold text-lg mb-3 text-green-700">Change Password</h3>
                @if(session('error'))
                    <div class="mb-2 w-full text-red-600 text-sm text-center">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="mb-2 w-full text-green-600 text-sm text-center">{{ session('success') }}</div>
                @endif
                <input type="password" name="current_password" placeholder="Current Password"
                    class="mb-2 px-4 py-2 border rounded-md focus:outline-none focus:border-green-600 focus:ring-green-600 w-full text-sm"
                    required autocomplete="current-password" />
                <input type="password" name="new_password" placeholder="New Password"
                    class="mb-2 px-4 py-2 border rounded-md focus:outline-none focus:border-green-600 focus:ring-green-600 w-full text-sm"
                    required autocomplete="new-password" />
                <input type="password" name="new_password_confirmation" placeholder="Confirm New Password"
                    class="mb-4 px-4 py-2 border rounded-md focus:outline-none focus:border-green-600 focus:ring-green-600 w-full text-sm"
                    required autocomplete="new-password" />
                <div class="flex gap-2 w-full">
                    <button type="button" onclick="hideChangePassword()"
                        class="flex-1 bg-gray-200 text-gray-700 rounded-lg py-2 hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 bg-green-600 text-white rounded-lg py-2 font-semibold hover:bg-green-700 transition">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal and Avatar Scripts -->
    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.3s cubic-bezier(.4, 0, .2, 1);
        }
    </style>
    <script>
        // Modal Password
        function showChangePassword() {
            document.getElementById('modalPassword').classList.remove('hidden');
        }

        function hideChangePassword() {
            document.getElementById('modalPassword').classList.add('hidden');
        }
        // Live Avatar Preview
        function previewAvatar(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('avatarPreview').src = URL.createObjectURL(file);
            }
        }
        // Hide modal when clicking outside the modal content
        document.getElementById('modalPassword').addEventListener('mousedown', function(e) {
            if (e.target === this) {
                hideChangePassword();
            }
        });
    </script>
@endsection
