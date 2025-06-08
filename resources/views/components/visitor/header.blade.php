<header id="header" class="bg-white" x-data="{ mobileMenu: false, productMenu: false, mobileProduct: false }">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img class="h-10 w-auto" src="{{ asset('img/Logo-transparent.png') }}" alt="">
            </a>
        </div>
        <!-- Hamburger -->
        <div class="flex lg:hidden">
            <button @click="mobileMenu = true" type="button"
                class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                :aria-expanded="mobileMenu" aria-controls="mobile-menu">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        @auth
            <!-- Main Menu -->
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="{{ route('home') }}"
                    class="text-sm font-semibold text-gray-900 hover:text-indigo-600 transition">Home</a>
                <!-- Desktop Product Dropdown -->
                <div class="relative" x-data="{
                    open: false,
                    trigger(e) { if (e.type === 'mouseenter') this.open = true; if (e.type === 'mouseleave') this.open = false; }
                }" @mouseenter="trigger($event)" @mouseleave="trigger($event)">
                    <button type="button" @click="open = !open" @focus="open = true" @blur="setTimeout(()=>open=false,200)"
                        class="flex items-center gap-x-1 text-sm font-semibold text-gray-900"
                        :aria-expanded="open.toString()">
                        My Account
                        <svg class="size-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1" @click.away="open=false"
                        class="absolute top-full right-0 z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5"
                        tabindex="-1">
                        <div class="p-4">
                            <!-- Menu items here (same as your HTML) -->
                            <!-- ... analytics, engagement, etc ... -->
                            <div
                                class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm hover:bg-gray-50 transition {{ request()->routeIs('visitor.profile') ? 'bg-gray-100' : '' }}">
                                <div
                                    class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                    <svg class="size-6 {{ request()->routeIs('visitor.profile') ? 'text-indigo-600' : 'text-gray-600 group-hover:text-indigo-600' }} transition"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a7.5 7.5 0 0115 0v.75a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75v-.75z" />
                                    </svg>
                                </div>
                                <div class="flex-auto">
                                    <a href="{{ route('visitor.profile') }}"
                                        class="block font-semibold {{ request()->routeIs('visitor.profile') ? 'text-indigo-600 font-bold' : 'text-gray-900' }}">
                                        {{ $getUser->username }}
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">
                                        As a <strong>{{ $getUser->roles->pluck('role_name')->contains('customer') ? 'customer' : '' }}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                            @if ($getUser->roles->pluck('role_name')->contains('seller'))
                                <div
                                    class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm hover:bg-gray-50 transition {{ request()->routeIs('seller.dashboard') || request()->is('seller/*') ? 'bg-gray-100' : '' }}">
                                    <div
                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white transition">
                                        <svg class="size-6 {{ request()->routeIs('seller.dashboard') || request()->is('seller/*') ? 'text-indigo-600' : 'text-gray-600 group-hover:text-indigo-600' }} transition"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <!-- Dashboard icon (Heroicons outline: squares-2x2) -->
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75h6.5v6.5h-6.5v-6.5zm0 10h6.5v6.5h-6.5v-6.5zm10 0h6.5v6.5h-6.5v-6.5zm0-10h6.5v6.5h-6.5v-6.5z" />
                                        </svg>
                                    </div>
                                    <div class="flex-auto">
                                        <a href="{{ route('seller.dashboard') }}"
                                            class="block font-semibold {{ request()->routeIs('seller.dashboard') || request()->is('seller/*') ? 'text-indigo-600 font-bold' : 'text-gray-900' }}">
                                            Go to Seller Dashboard
                                            <span class="absolute inset-0"></span>
                                        </a>
                                        <p class="mt-1 text-gray-600">Switch to your seller dashboard</p>
                                    </div>
                                </div>
                            @endif
                            <div
                                class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm hover:bg-indigo-50 transition {{ request()->is('cart') ? 'bg-gray-100' : '' }}">
                                <!-- Icon Keranjang -->
                                <div
                                    class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white transition">
                                    <svg class="size-6 {{ request()->is('cart') ? 'text-indigo-800' : 'text-indigo-600 group-hover:text-indigo-800' }} transition"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 3.75h1.5l1.6 9.46a2.25 2.25 0 0 0 2.23 1.79h8.54a2.25 2.25 0 0 0 2.23-1.79l1.6-9.46h1.5M9 21a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm6 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z" />
                                    </svg>
                                </div>
                                <!-- Informasi Keranjang -->
                                <div class="flex-auto">
                                    <a href="/cart"
                                        class="block font-semibold {{ request()->is('cart') ? 'text-indigo-600 font-bold' : 'text-indigo-900' }} relative group-hover:underline transition">
                                        My Cart
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">Lihat dan kelola barang belanjaanmu di sini.</p>
                                </div>
                            </div>

                            <div
                                class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm hover:bg-gray-50 transition {{ request()->is('my-orders') || request()->routeIs('customer.orders.history') ? 'bg-gray-100' : '' }}">
                                <!-- Icon pesanan (clipboard/checklist atau paket) -->
                                <div
                                    class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white transition">
                                    <svg class="size-6 {{ request()->is('my-orders') || request()->routeIs('customer.orders.history') ? 'text-indigo-600' : 'text-gray-600 group-hover:text-indigo-600' }} transition"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <!-- Icon clipboard dengan checklist (Heroicons style) -->
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3.75a2.25 2.25 0 0 0-2.25 2.25v.75h-1.5A2.25 2.25 0 0 0 6 9.75v8.25A2.25 2.25 0 0 0 8.25 20.25h7.5A2.25 2.25 0 0 0 18 18V9.75a2.25 2.25 0 0 0-2.25-2.25h-1.5v-.75A2.25 2.25 0 0 0 12 3.75z" />
                                    </svg>
                                </div>
                                <div class="flex-auto">
                                    <a href="{{ route('customer.orders.history') }}"
                                        class="block font-semibold {{ request()->is('my-orders') || request()->routeIs('customer.orders.history') ? 'text-indigo-600 font-bold' : 'text-gray-900' }}">
                                        My Order
                                        <span class="absolute inset-0"></span>
                                    </a>
                                    <p class="mt-1 text-gray-600">Lihat status & riwayat pesananmu di sini.</p>
                                </div>
                            </div>


                            <form method="POST" action="{{ route('logout') }}"
                                class="group relative flex items-center gap-x-6 rounded-lg p-4 text-sm hover:bg-gray-50 logout-form">
                                @csrf
                                <button type="submit" class="flex items-center gap-x-6 w-full text-left logout-btn">
                                    <div
                                        class="flex size-11 flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
                                        <svg class="size-6 text-gray-600 group-hover:text-indigo-600" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3A2.25 2.25 0 0 0 8.25 5.25V9m7.5 6v3.75A2.25 2.25 0 0 1 13.5 21h-3A2.25 2.25 0 0 1 8.25 18.75V15m-3-3h13.5m0 0-3.75-3.75m3.75 3.75-3.75 3.75" />
                                        </svg>
                                    </div>
                                    <div class="flex-auto">
                                        <span class="block font-semibold text-gray-900">
                                            Logout
                                            <span class="absolute inset-0"></span>
                                        </span>
                                        <p class="mt-1 text-gray-600">Sign out of your account</p>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
        @guest
            <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-4">
                <x-visitor.nav-link href="{{ route('register') }}" class="text-sm font-semibold text-gray-900">Sign Up
                    <span aria-hidden="true">&rarr;</span></x-visitor.nav-link>
                <x-visitor.nav-link href="{{ route('login') }}" class="text-sm font-semibold text-gray-900">Sign In <span
                        aria-hidden="true">&rarr;</span></x-visitor.nav-link>
            </div>
        @endguest
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div x-show="mobileMenu" x-transition:enter="transition-opacity ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 bg-black/30 lg:hidden"
        @click="mobileMenu = false" aria-hidden="true"></div>
    <div x-show="mobileMenu" x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-30 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10 lg:hidden"
        id="mobile-menu" @keydown.escape.window="mobileMenu = false">
        <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img class="h-10 w-auto" src="{{ asset('img/Logo-transparent-2.png') }}" alt="">
            </a>
            <button @click="mobileMenu = false" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700"
                aria-label="Close menu">
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
                @auth
                    <div class="space-y-2 py-6">
                        <!-- Mobile Product Disclosure -->
                        <div class="-mx-3" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex w-full items-center justify-between rounded-lg py-2 pr-3.5 pl-3 text-base font-semibold text-gray-900 hover:bg-gray-50"
                                aria-controls="disclosure-1" :aria-expanded="open.toString()">
                                My Account
                                <svg :class="{ 'rotate-180': open }" class="size-5 flex-none transition-transform"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" x-collapse>
                                <a href="{{ route('visitor.profile') }}"
                                    class="block rounded-lg py-2 pr-3 pl-6 text-sm font-semibold text-gray-900 hover:bg-gray-50">Profile</a>
                                @if ($getUser->roles->pluck('role_name')->contains('seller'))
                                    <a href="{{ route('seller.dashboard') }}"
                                        class="block rounded-lg py-2 pr-3 pl-6 text-sm font-semibold text-gray-900 hover:bg-gray-50">Go
                                        to Seller Dashboard</a>
                                @endif
                                <a href="#"
                                    class="block rounded-lg py-2 pr-3 pl-6 text-sm font-semibold text-gray-900 hover:bg-gray-50">My
                                    Cart</a>
                                <a href="#"
                                    class="block rounded-lg py-2 pr-3 pl-6 text-sm font-semibold text-gray-900 hover:bg-gray-50">My
                                    Order</a>
                                <a href="#"
                                    class="block rounded-lg py-2 pr-3 pl-6 text-sm font-semibold text-gray-900 hover:bg-gray-50">Logout</a>
                            </div>
                        </div>
                    </div>
                @endauth
                @guest
                    <div class="py-6">
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold text-gray-900 hover:bg-gray-50">Sign
                            Up</a>
                        <a href="#"
                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold text-gray-900 hover:bg-gray-50">Sign
                            In</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.logout-form').forEach(function(form) {
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
        // Mobile menu logout
        document.querySelectorAll('a').forEach(function(a) {
            if (a.textContent.trim() === 'Logout') {
                a.addEventListener('click', function(e) {
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
                            // Create and submit a hidden logout form
                            let form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('logout') }}";
                            form.innerHTML = '@csrf';
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cartBadge = document.querySelector('#cart-badge');
        const updateCartCount = async () => {
            try {
                const response = await fetch('/api/cart/count');
                const data = await response.json();
                if (data.count > 0) {
                    cartBadge.style.display = 'flex';
                    cartBadge.textContent = data.count;
                } else {
                    cartBadge.style.display = 'none';
                }
            } catch (error) {
                console.error('Failed to update cart count:', error);
            }
        };
        updateCartCount();
        setInterval(updateCartCount, 30000); // Update every 30 seconds
    });
</script>
