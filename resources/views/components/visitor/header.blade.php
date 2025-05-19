<header id="header">
    <nav
        class="
          flex flex-wrap
          items-center
          justify-between
          w-full
          py-4
          md:py-0
          px-4
          text-lg text-gray-700
          bg-[#f5f5f5]
        ">
        <div>
            <a href="#">
                <img src="{{ asset('img/Logo-transparent.png') }}" class="w-[150px]" alt="">
            </a>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" id="menu-button" class="h-6 w-6 cursor-pointer md:hidden block"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>

        <div class="hidden w-full md:flex md:items-center md:w-auto" id="menu">
            <ul
                class="
              pt-4
              text-base text-gray-700
              md:flex
              md:justify-between
              md:items-center
              md:pt-0">
                <li>
                    <x-visitor.nav-link href="{{ route('register') }}"><i class="ri-heart-2-line"></i> My Favorite</x-visitor.nav-link>
                </li>
                <li>
                    <x-visitor.nav-link href="#">
                        <div class="w-[35px] text-lg aspect-square grid place-items-center rounded-full border-[1px] border-gray-500"><i class="ri-user-6-line"></i></div>
                    </x-visitor.nav-link>
                </li>
            </ul>
        </div>
    </nav>
</header>
