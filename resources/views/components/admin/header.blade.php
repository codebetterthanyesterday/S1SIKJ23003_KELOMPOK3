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
                <x-admin.nav-link href="" class="flex ms-2 md:me-24">
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap">Admin
                        Application</span>
                </x-admin.nav-link>
            </div>
            <div class="flex items-center">
                <div class="relative">
                    <button type="button" class="cursor-pointer p-2 focus:outline-none"
                        id="adminNotificationModalButton" aria-expanded="false" aria-haspopup="true"
                        aria-controls="adminNotificationModal" aria-label="Open notifications">
                        <i class="ri-notification-4-fill text-gray-600 text-xl"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 border border-white"
                            style="font-size:10px;">3</span>
                    </button>
                    <!-- Modal backdrop -->
                    <div id="adminNotificationModalBackdrop" class="hidden fixed inset-0 bg-[rgba(0,0,0,0.8)] z-40">
                    </div>
                    <!-- Modal dialog -->
                    <div id="adminNotificationModal"
                        class="hidden fixed inset-0 z-50 flex items-center justify-center px-2">
                        <div class="bg-white rounded-md shadow-lg border border-gray-100 w-full max-w-md mx-auto relative"
                            id="adminNotificationModalContent">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                                <span class="font-semibold text-gray-700">Notifications</span>
                                <div class="flex items-center gap-2">
                                    <button class="text-xs text-green-600 hover:underline focus:outline-none"
                                        onclick="adminMarkAllRead()" type="button">Mark all as read</button>
                                    <button type="button" id="adminNotificationModalCloseBtn"
                                        class="ml-2 text-gray-400 hover:text-gray-700 focus:outline-none"
                                        aria-label="Close notifications">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <ul class="max-h-72 overflow-y-auto divide-y divide-gray-100" role="list">
                                <li class="px-4 py-3 hover:bg-gray-50 transition flex items-start gap-2"
                                    role="listitem">
                                    <span class="mt-1 text-green-500"><i class="ri-check-double-line"></i></span>
                                    <div>
                                        <p class="text-sm text-gray-700">User <b>john_doe</b> registered.</p>
                                        <span class="text-xs text-gray-400">2 min ago</span>
                                    </div>
                                </li>
                                <li class="px-4 py-3 hover:bg-gray-50 transition flex items-start gap-2"
                                    role="listitem">
                                    <span class="mt-1 text-blue-500"><i class="ri-user-add-line"></i></span>
                                    <div>
                                        <p class="text-sm text-gray-700">New seller application received.</p>
                                        <span class="text-xs text-gray-400">15 min ago</span>
                                    </div>
                                </li>
                                <li class="px-4 py-3 hover:bg-gray-50 transition flex items-start gap-2"
                                    role="listitem">
                                    <span class="mt-1 text-yellow-500"><i class="ri-alert-line"></i></span>
                                    <div>
                                        <p class="text-sm text-gray-700">Product <b>Widget X</b> is out of stock.</p>
                                        <span class="text-xs text-gray-400">1 hour ago</span>
                                    </div>
                                </li>
                                <!-- More notifications here -->
                            </ul>
                            <div class="px-4 py-2 border-t border-gray-100 text-center">
                                <a href="#" class="text-sm text-green-600 hover:underline">View all</a>
                            </div>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const btn = document.getElementById('adminNotificationModalButton');
                            const modal = document.getElementById('adminNotificationModal');
                            const backdrop = document.getElementById('adminNotificationModalBackdrop');
                            const closeBtn = document.getElementById('adminNotificationModalCloseBtn');
                            const modalContent = document.getElementById('adminNotificationModalContent');

                            function openModal() {
                                modal.classList.remove('hidden');
                                backdrop.classList.remove('hidden');
                                btn.setAttribute('aria-expanded', 'true');
                            }

                            function closeModal() {
                                modal.classList.add('hidden');
                                backdrop.classList.add('hidden');
                                btn.setAttribute('aria-expanded', 'false');
                            }

                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                openModal();
                            });

                            if (closeBtn) {
                                closeBtn.addEventListener('click', function(e) {
                                    e.stopPropagation();
                                    closeModal();
                                });
                            }

                            // Close modal when clicking on backdrop
                            backdrop.addEventListener('click', function() {
                                closeModal();
                            });

                            // Close modal on Escape key
                            document.addEventListener('keydown', function(e) {
                                if (!modal.classList.contains('hidden') && e.key === 'Escape') {
                                    closeModal();
                                }
                            });

                            // Prevent closing when clicking inside modal content
                            modalContent.addEventListener('click', function(e) {
                                e.stopPropagation();
                            });

                            // Close modal when clicking outside modal content (on modal area)
                            modal.addEventListener('click', function(e) {
                                if (e.target === modal) {
                                    closeModal();
                                }
                            });
                        });

                        // Dummy mark all as read
                        function adminMarkAllRead() {
                            // You can implement AJAX here
                            alert('All notifications marked as read!');
                        }
                    </script>
                </div>
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex cursor-pointer text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="{{ $getUser->profile_picture ? asset('storage/profile_pictures/' . $getUser->profile_picture) : asset('img/blank-profile-picture.png') }}"
                                alt="user photo">
                        </button>
                    </div>
                    <div class="z-50 user-dropdown hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900" role="none">
                                {{ $getUser->username }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate" role="none">
                                {{ $getUser->email }}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <x-admin.nav-link href="{{ route('admin.profile') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</x-admin.nav-link>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="admin-logout-form">
                                    @csrf
                                    <x-admin.nav-link href="javascript:void(0)"
                                        class="block do-logout px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem">Sign out</x-admin.nav-link>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.admin-logout-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Logout?',
                    text: 'Are you sure you want to log out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
        document.querySelectorAll('.do-logout').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Logout?',
                    text: 'Are you sure you want to log out?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
