<header class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="" class="flex ms-2 md:me-24">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">Seller
                        Application</span>
                </a>
            </div>
            <div class="flex items-center">
                <script>
                    // Notification dropdown toggle for seller
                    document.addEventListener('DOMContentLoaded', function() {
                        const btn = document.getElementById('sellerNotificationDropdownButton');
                        const dropdown = document.getElementById('sellerNotificationDropdown');
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            dropdown.classList.toggle('hidden');
                            btn.setAttribute('aria-expanded', dropdown.classList.contains('hidden') ? 'false' : 'true');
                        });
                        // Hide dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            if (!dropdown.classList.contains('hidden')) {
                                dropdown.classList.add('hidden');
                                btn.setAttribute('aria-expanded', 'false');
                            }
                        });
                        // Prevent closing when clicking inside dropdown
                        dropdown.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    });
                    // Dummy mark all as read
                    function sellerMarkAllRead() {
                        // You can implement AJAX here
                        alert('All notifications marked as read!');
                    }
                </script>
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex cursor-pointer text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="{{ $getUser->profile_picture ? asset('storage/user_avatar/' . $getUser->profile_picture) : 'https://static.vecteezy.com/system/resources/previews/009/292/244/non_2x/default-avatar-icon-of-social-media-user-vector.jpg' }}"
                                alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900" role="none">
                                {{ $getUser->username }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                {{ $getUser->email }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                As a <strong>{{ $getUser->roles->pluck('role_name')->contains('seller') ? 'seller' : '' }}
                                </strong>
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            {{-- <li>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">My Profile</a>
                                </li> --}}
                            <li>
                                <a href="{{ route('home') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    Home
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">
                                        Sign out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
