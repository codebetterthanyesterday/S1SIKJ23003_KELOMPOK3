<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">
            <li>
                <x-seller.nav-link href="{{ route('seller.dashboard') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z">
                        </path>
                    </svg><span class="ms-3">Dashboard</span>
                </x-seller.nav-link>
            </li>
            <li>
                <x-seller.nav-link href="{{ route('seller.list', 'order') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 202.614 202.614"
                        fill="currentColor">
                        <path d="M177.91,55.377h-22.589v-1.368C155.311,24.25,131.091,0,101.302,0
                        C71.503,0,47.292,24.25,47.292,54.009v1.368H24.704L11.495,202.614h179.624L177.91,55.377L177.91,55.377z
                        M101.302,6.624c19.687,0,36.619,12.105,43.761,29.232c-9.448-14.137-25.5-23.478-43.761-23.478
                        c-18.231,0-34.313,9.34-43.77,23.507C64.713,18.729,81.635,6.624,101.302,6.624z
                        M57.297,55.377c4.406-20.263,22.481-35.485,44.024-35.485
                        c21.582,0,39.618,15.222,44.024,35.485H57.297z">
                        </path>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Orders</span>
                </x-seller.nav-link>
            </li>
            <li>
                <x-seller.nav-link href="{{ route('seller.creation', 'store') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M3 13h1v7c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-7h1c.4 0 .77-.24.92-.62.16-.37.07-.8-.22-1.09l-8.99-9a.996.996 0 0 0-1.41 0l-9.01 9c-.29.29-.37.72-.22 1.09s.52.62.92.62Zm5 0h3v-3h2v3h3v2h-3v3h-2v-3H8z">
                        </path>
                    </svg><span class="flex-1 ms-3 whitespace-nowrap">New Store</span>
                </x-seller.nav-link>
            </li>
            <li>
                <x-seller.nav-link href="{{ route('seller.list', 'store') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 2H19V4H5z"></path>
                        <path
                            d="m19.1,5.8c-.38-.5-.97-.8-1.6-.8H6.5c-.63,0-1.23.3-1.6.8l-2.5,3.33c-.26.34-.4.77-.4,1.2v2.67c0,.55.45,1,1,1v7c0,.55.45,1,1,1h8c.55,0,1-.45,1-1v-7h6v8h2v-8c.55,0,1-.45,1-1v-2.67c0-.43-.14-.86-.4-1.2l-2.5-3.33Zm-8.1,14.2h-6v-6h6v6Z">
                        </path>
                    </svg><span class="flex-1 ms-3 whitespace-nowrap">My Stores</span>
                </x-seller.nav-link>
            </li>
            <li>
                <x-seller.nav-link href="{{ route('seller.creation', 'product') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M4 3C3.44772 3 3 3.44772 3 4V10C3 10.5523 3.44772 11 4 11H10C10.5523 11 11 10.5523 11 10V4C11 3.44772 10.5523 3 10 3H4ZM4 13C3.44772 13 3 13.4477 3 14V20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V14C11 13.4477 10.5523 13 10 13H4ZM14 13C13.4477 13 13 13.4477 13 14V20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V14C21 13.4477 20.5523 13 20 13H14ZM16 11V8H13V6H16V3H18V6H21V8H18V11H16Z">
                        </path>
                    </svg><span class="flex-1 ms-3 whitespace-nowrap">New Product</span>
                </x-seller.nav-link>
            </li>
            <li>
                <x-seller.nav-link href="{{ route('seller.list', 'product') }}"
                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                    <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="m21.96,7.74s-.02-.05-.03-.07c-.02-.06-.04-.11-.07-.17-.02-.03-.04-.05-.06-.08-.03-.04-.06-.09-.1-.13-.03-.03-.06-.04-.08-.07-.04-.03-.07-.06-.11-.09,0,0,0,0-.01,0,0,0,0,0,0,0L12.49,2.13c-.3-.17-.67-.17-.97,0L2.58,7.1s-.06.02-.09.04c-.31.18-.49.51-.49.86v8c0,.36.2.7.51.87l9,5s.1.04.14.06c.03.01.06.03.09.03.08.02.17.03.25.03s.17-.01.25-.03c.03,0,.06-.02.09-.03.05-.02.1-.03.14-.06l9-5c.32-.18.51-.51.51-.87v-8c0-.09-.01-.18-.04-.26Zm-9.96-3.59l6.94,3.86-2.24,1.25-6.84-3.91,2.14-1.19Zm0,7.71l-6.92-3.86,2.74-1.52,6.84,3.91-2.65,1.47Zm8,3.56l-7,3.89v-5.71l3-1.67v3.08l2-1v-3.19l2-1.11v5.71Z">
                        </path>
                    </svg><span class="flex-1 ms-3 whitespace-nowrap">My Products</span>
                </x-seller.nav-link>
            </li>
        </ul>
    </div>
</aside>
