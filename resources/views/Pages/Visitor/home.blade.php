@extends('layout.app')

@section('title', 'Home')

@section('content')
    @php
        $currentCategory = null;
        if (!empty($category_slug)) {
            $currentCategory = $category_slug;
        }
    @endphp
    <section id="category_grid">
        <div class="w-full">
            <div class="grid md:grid-cols-3 gap-0.5 grid-cols-1">
                <div id="bigger_category" class="w-full md:col-span-2 gap-0.5 grid grid-cols-1">
                    <div class="category_item">
                        <x-visitor.nav-link class="{{ request()->is('category/gourmet-entrees') ? 'active-category' : '' }}"
                            href="{{ route('category.getproduct', Illuminate\Support\Str::slug('Gourmet Entrées')) }}"><span>Gourmet
                                Entrées</span></x-visitor.nav-link>
                        <div>
                            <img src="https://plus.unsplash.com/premium_photo-1673108852141-e8c3c22a4a22?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="">
                        </div>
                    </div>
                    <div class="category_item">
                        <x-visitor.nav-link
                            class="{{ request()->is('category/petite-pleasures') ? 'active-category' : '' }}"
                            href="{{ route('category.getproduct', Illuminate\Support\Str::slug('Petite Pleasures')) }}"><span>Petite
                                Pleasures</span></x-visitor.nav-link>
                        <div>
                            <img src="https://plus.unsplash.com/premium_photo-1667114974806-1b8af9ee8fee?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="">
                        </div>
                    </div>
                </div>
                <div id="smaller_category" class="w-full md:col-span-1 gap-0.5 grid grid-cols-1">
                    <div class="category_item">
                        <x-visitor.nav-link
                            class="{{ request()->is('category/refined-refreshments') ? 'active-category' : '' }}"
                            href="{{ route('category.getproduct', Illuminate\Support\Str::slug('Refined Refreshments')) }}"><span>Refined
                                Refreshments</span></x-visitor.nav-link>
                        <div>
                            <img src="https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1557&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="">
                        </div>
                    </div>
                    <div class="category_item">
                        <x-visitor.nav-link
                            class="{{ request()->is('category/harvest-elegance') ? 'active-category' : '' }}"
                            href="{{ route('category.getproduct', Illuminate\Support\Str::slug('Harvest Elegance')) }}"><span>Harvest
                                Elegance</span></x-visitor.nav-link>
                        <div>
                            <img src="https://plus.unsplash.com/premium_photo-1721822420816-812a351499ee?q=80&w=1492&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="">
                        </div>
                    </div>
                </div>
                {{-- @foreach ($productCategories as $index => $category)
                    @if ($index < 2)
                        @if ($index == 0)
                        <div id="bigger_category" class="w-full md:col-span-2 gap-0.5 grid grid-cols-1">
                        @endif
                            <div class="category_item">
                                <x-visitor.nav-link
                                    class="{{ request()->is('category/' . Illuminate\Support\Str::slug($category->name)) ? 'active-category' : '' }}"
                                    href="{{ route('category.getproduct', Illuminate\Support\Str::slug($category->name)) }}">
                                    <span>{{ $category->name }}</span>
                                </x-visitor.nav-link>
                                <div>
                                    <img src="{{ $category->image_url }}" alt="">
                                </div>
                            </div>
                        @if ($index == 1)
                        </div>
                        @endif
                    @elseif($index == 2)
                        <div id="smaller_category" class="w-full md:col-span-1 gap-0.5 grid grid-cols-1">
                            <div class="category_item">
                                <x-visitor.nav-link
                                    class="{{ request()->is('category/' . Illuminate\Support\Str::slug($category->name)) ? 'active-category' : '' }}"
                                    href="{{ route('category.getproduct', Illuminate\Support\Str::slug($category->name)) }}">
                                    <span>{{ $category->name }}</span>
                                </x-visitor.nav-link>
                                <div>
                                    <img src="{{ $category->image_url }}" alt="">
                                </div>
                            </div>
                    @elseif($index > 2 && $index < 4)
                            <div class="category_item">
                                <x-visitor.nav-link
                                    class="{{ request()->is('category/' . Illuminate\Support\Str::slug($category->name)) ? 'active-category' : '' }}"
                                    href="{{ route('category.getproduct', Illuminate\Support\Str::slug($category->name)) }}">
                                    <span>{{ $category->name }}</span>
                                </x-visitor.nav-link>
                                <div>
                                    <img src="{{ $category->image_url }}" alt="">
                                </div>
                            </div>
                        @if ($index == 3)
                        </div>
                        @endif
                    @endif
                @endforeach --}}
            </div>
        </div>
    </section>
    <!-- 1. Hero Search & Filter -->


    <!-- Modern Minimalist Home Dashboard for Langsung-PO -->

    <!-- Hero Welcome Section -->
    <section class="relative bg-gradient-to-br home-section py-16 mb-8" id="searching">
        <div class="max-w-3xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">Selamat Datang di <span
                    class="text-green-600">Langsung-PO</span></h1>
            <p class="text-lg text-gray-500 mb-8">Pesan makanan favoritmu, nikmati promo spesial, dan temukan merchant
                terbaik di kotamu. Semua dalam satu dashboard yang simpel dan elegan.</p>
            <form id="live-search-form" class="relative z-[1] w-full max-w-lg mx-auto " autocomplete="off">
                <input id="live-search-input" type="search" name="q"
                    placeholder="Cari makanan, minuman, atau toko..."
                    class="w-full pr-14 px-4 py-3 rounded-lg border border-gray-200 bg-gray-100 focus:ring-2 focus:ring-green-400 focus:outline-none transition" />
                <button type="submit"
                    class="absolute right-2 top-2 bottom-2 bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition flex items-center gap-1 shadow"
                    style="min-height:2.25rem;">
                    <i class="ri-search-line text-lg"></i>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </form>
            <div id="live-search-results"
                class="absolute z-[99999] bg-white right-2 left-2 sm:right-0 sm:left-0 max-w-md mx-auto mt-2 rounded-xl shadow-2xl border border-gray-100 overflow-hidden hidden">
            </div>
            <div
                class="absolute right-0 bottom-0 w-32 md:w-48 opacity-20 pointer-events-none select-none flex flex-col items-end gap-2">
                <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" alt="Food Illustration"
                    class="w-full h-auto" />
            </div>
            <div
                class="absolute left-0 bottom-0 w-32 md:w-48 opacity-20 pointer-events-none select-none flex flex-col items-end gap-2">

                <img src="https://cdn-icons-png.flaticon.com/512/2921/2921822.png" alt="Dish Illustration"
                    class="w-full h-auto" />
            </div>
        </div>
    </section>

    <!-- Promo Running Slider Full Width (No Horizontal Overflow) -->
    {{-- <section class="py-8 w-full overflow-x-hidden">
        <div class="w-full px-0">
            <div x-data="{
                promos: [
                    { img: 'https://source.unsplash.com/1600x500/?food,promo,1', title: 'Promo Spesial #1', desc: 'Diskon hingga 30% untuk menu pilihan!' },
                    { img: 'https://source.unsplash.com/1600x500/?food,promo,2', title: 'Promo Spesial #2', desc: 'Diskon hingga 30% untuk menu pilihan!' },
                    { img: 'https://source.unsplash.com/1600x500/?food,promo,3', title: 'Promo Spesial #3', desc: 'Diskon hingga 30% untuk menu pilihan!' },
                ],
                active: 0,
                interval: null,
                start() {
                    this.interval = setInterval(() => {
                        this.active = (this.active + 1) % this.promos.length;
                    }, 3500);
                },
                stop() {
                    clearInterval(this.interval);
                }
            }" x-init="start()" @mouseenter="stop()" @mouseleave="start()"
                class="relative w-full overflow-hidden">
                <!-- Slides -->
                <div class="flex transition-transform duration-700 ease-in-out"
                    :style="`width: ${promos.length * 100}%; transform: translateX(-${active * 100}%);`">
                    <template x-for="(promo, idx) in promos" :key="idx">
                        <div class="w-full flex-shrink-0">
                            <div
                                class="relative w-full h-56 md:h-72 lg:h-80 flex items-center justify-center bg-white shadow-md hover:shadow-lg transition overflow-hidden">
                                <img :src="promo.img" :alt="promo.title" class="w-full h-full object-cover" />
                                <div
                                    class="absolute left-0 right-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent px-8 py-6">
                                    <h3 class="font-semibold text-2xl md:text-3xl text-white mb-1" x-text="promo.title">
                                    </h3>
                                    <p class="text-base md:text-lg text-white/80" x-text="promo.desc"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <!-- Dots -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                    <template x-for="(promo, idx) in promos" :key="idx">
                        <button class="w-3 h-3 rounded-full"
                            :class="active === idx ? 'bg-green-600' : 'bg-white/70 border border-green-600'"
                            @click="active = idx" aria-label="Go to slide"></button>
                    </template>
                </div>
            </div>
        </div>
    </section> --}}
    <!--
                                                                                                                                            NOTE:
                                                                                                                                            - This version uses percentage widths (100%) for slides and container, so it will not overflow the viewport.
                                                                                                                                            - The previous version used vw units and negative margins, which can cause horizontal scrolling/overflow.
                                                                                                                                            - The section and slider containers have overflow-x-hidden to prevent accidental overflow.
                                                                                                                                            -->




    @if (!empty($trendingProducts))
        <section class="py-10 bg-gradient-to-b from-white via-green-50 to-white" x-data="{ showAll: false }">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex items-center justify-center text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Menu Trending</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ($trendingProducts as $i => $product)
                        <template x-if="showAll || {{ $i }} < 8">
                            <a href="{{ route('product.show', $product->slug) }}"
                                class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col overflow-hidden group">
                                <img src="{{ $product->product_image ? asset('storage/product_images/' . $product->product_image) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                    alt="{{ $product->product_name }}" class="w-full h-32 object-cover" />
                                <div class="p-4 flex-1 flex flex-col">
                                    <h3 class="font-semibold text-gray-800 mb-1">{{ $product->product_name }}</h3>
                                    <p class="text-green-600 font-bold mb-2">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <div class="text-xs text-gray-500 mb-2 truncate">
                                        {{ $product->category?->category_name }} &bull; {{ $product->store?->store_name }}
                                    </div>
                                    <button
                                        class="add-to-cart-btn w-full px-3 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold hover:bg-green-200 transition flex items-center justify-center gap-1"
                                        data-name="{{ $product->product_name }}" data-price="{{ $product->price }}"
                                        data-id="{{ $product->id_product }}" data-slug="{{ $product->slug }}"
                                        data-image="{{ $product->product_image ? asset('storage/' . $product->product_image) : 'https://via.placeholder.com/400x300?text=No+Image' }}">
                                        <i class="ri-shopping-cart-2-fill"></i> Add to cart
                                    </button>
                                </div>
                            </a>
                        </template>
                    @endforeach
                </div>
                <div class="flex justify-center mt-6">
                    <button @click="showAll = !showAll"
                        class="flex items-center gap-2 px-5 py-2 rounded-full font-medium text-sm
                            border border-green-600
                            text-green-600
                            bg-white
                            hover:bg-green-50
                            focus:outline-none focus:ring-2 focus:ring-green-400
                            transform
                            duration-300
                            active:scale-95
                            shadow
                            hover:shadow-md"
                        :aria-pressed="showAll.toString()" :class="showAll ? 'animate-pulse' : ''">
                        <template x-if="!showAll">
                            <span class="flex items-center">
                                <span>Lihat Semua</span>
                                <svg class="inline w-4 h-4 ml-1 transition-transform duration-300"
                                    :class="!showAll ? 'rotate-0' : 'rotate-180'" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </template>
                        <template x-if="showAll">
                            <span class="flex items-center">
                                <span>Tampilkan Lebih Sedikit</span>
                                <svg class="inline w-4 h-4 ml-1 transition-transform duration-300"
                                    :class="showAll ? 'rotate-0' : 'rotate-180'" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
                                </svg>
                            </span>
                        </template>
                    </button>
                </div>
            </div>
        </section>
    @endif

    @if ($newEntities->count() > 0)
        <section class="py-10">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Baru di Langsung-PO</h2>
                </div>
                <div x-data="carouselDemoEnhancedCentered({{ $newEntities->toJson() }})" x-init="init()" @mouseenter="pause()" @mouseleave="play()"
                    class="relative flex flex-col items-center" role="region" aria-label="Baru di Langsung-PO Carousel">
                    <!-- Carousel Slides -->
                    <div class="relative w-full py-4 overflow-hidden" tabindex="0" aria-live="polite">
                        <div class="flex transition-transform duration-700 ease-in-out"
                            :style="`transform: translateX(-${active * 100}%);`">
                            <template x-for="(slide, slideIdx) in slides" :key="slideIdx">
                                <div class="flex gap-6 w-full flex-shrink-0 justify-center" style="min-width: 100%;">
                                    <template x-for="(item, idx) in slide" :key="idx">
                                        <a :href="item.type === 'Store' ? `/store/${item.slug}` : `/product/${item.slug}`"
                                            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden relative w-full max-w-xs flex flex-col border border-gray-100 hover:border-green-200 focus-within:ring-2 focus-within:ring-green-500"
                                            :aria-label="item.title" tabindex="0">
                                            <span
                                                class="absolute z-[99999] left-0 top-4 py-1 px-4 rounded-r-full text-xs font-semibold shadow"
                                                :class="item.type === 'Store' ? 'bg-orange-500 text-white' :
                                                    'bg-green-600 text-white'"
                                                x-text="item.type === 'Store' ? 'Toko' : 'Menu'"
                                                :aria-label="item.type"></span>
                                            <div class="relative">
                                                <img :src="item.type === 'Store' ? item.img_banner : item.img"
                                                    :alt="item.title"
                                                    class="w-full h-36 object-cover group-hover:scale-105 transition-transform duration-500"
                                                    loading="lazy" />
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent">
                                                </div>
                                                <template x-if="item.isNew">
                                                    <span
                                                        class="absolute right-2 top-2 bg-yellow-400 text-white text-[10px] px-2 py-0.5 rounded-full font-bold shadow">NEW</span>
                                                </template>
                                            </div>
                                            <div class="p-5 flex-1 flex flex-col">
                                                <h3 class="font-bold text-gray-800 text-lg mb-1 transition-colors"
                                                    x-text="item.title"></h3>
                                                <p class="text-xs text-gray-500 mb-2" x-text="item.desc"></p>
                                                <p class="text-xs text-gray-400 mb-2" x-text="item.created_at_human"></p>
                                                <template x-if="item.price">
                                                    <div class="flex items-center gap-1 mb-2">
                                                        <span class="text-green-600 font-bold text-base"
                                                            x-text="(new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 })).format(item.price)"></span>
                                                    </div>
                                                </template>
                                                <div class="mt-auto flex items-center justify-between">
                                                    <span></span>
                                                    <span
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-100 text-green-700 text-xs font-semibold hover:bg-green-200 transition focus:outline-none focus:ring-2 focus:ring-green-500">
                                                        Lihat
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- Carousel Controls -->
                    <div class="flex items-center justify-center w-full mt-4 gap-4">
                        <button @click="prev"
                            class="p-2 rounded-full bg-white/80 shadow hover:bg-green-100 transition focus:outline-none focus:ring-2 focus:ring-green-600"
                            aria-label="Sebelumnya" :tabindex="slideCount > 1 ? 0 : -1">
                            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <!-- Carousel indicators -->
                        <div class="flex justify-center space-x-2" aria-label="Navigasi slide">
                            <template x-for="(slide, idx) in slides" :key="idx">
                                <button @click="goTo(idx)"
                                    :class="active === idx ? (slides[idx][0]?.type === 'Store' ? 'bg-orange-500 scale-110' :
                                        'bg-green-600 scale-110') : 'bg-gray-300'"
                                    class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none"
                                    :class="active === idx ?
                                        (slides[idx][0]?.type === 'Store' ?
                                            'focus:ring-orange-600' :
                                            'focus:ring-green-600') :
                                        ''"
                                    :aria-current="active === idx ? 'true' : 'false'" :tabindex="slideCount > 1 ? 0 : -1"
                                    :aria-label="`Slide ${idx+1}`"></button>
                            </template>
                        </div>
                        <button @click="next"
                            class="p-2 rounded-full bg-white/80 shadow hover:bg-green-100 transition focus:outline-none focus:ring-2 focus:ring-green-600"
                            aria-label="Selanjutnya" :tabindex="slideCount > 1 ? 0 : -1">
                            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>
        <script>
            function carouselDemoEnhancedCentered(items) {
                return {
                    items: items,
                    perSlide: 3,
                    active: 0,
                    interval: null,
                    slides: [],
                    get slideCount() {
                        return this.slides.length;
                    },
                    updatePerSlide() {
                        if (window.innerWidth < 640) {
                            this.perSlide = 1;
                        } else if (window.innerWidth < 1024) {
                            this.perSlide = 2;
                        } else {
                            this.perSlide = 3;
                        }
                    },
                    buildSlides() {
                        this.slides = [];
                        for (let i = 0; i < this.items.length; i += this.perSlide) {
                            this.slides.push(this.items.slice(i, i + this.perSlide));
                        }
                        if (this.active >= this.slides.length) this.active = 0;
                    },
                    next() {
                        this.active = (this.active + 1) % this.slideCount;
                    },
                    prev() {
                        this.active = (this.active - 1 + this.slideCount) % this.slideCount;
                    },
                    goTo(idx) {
                        this.active = idx;
                    },
                    play() {
                        if (this.interval) clearInterval(this.interval);
                        this.interval = setInterval(() => {
                            this.next();
                        }, 4000);
                    },
                    pause() {
                        if (this.interval) clearInterval(this.interval);
                        this.interval = null;
                    },
                    init() {
                        this.updatePerSlide();
                        this.buildSlides();
                        window.addEventListener('resize', () => {
                            this.updatePerSlide();
                            this.buildSlides();
                        });
                        this.play();
                    }
                }
            }
        </script>
    @endif

    @if (!empty($recommendations) && $recommendations->count())
        <section class="py-10 bg-gradient-to-b from-white via-green-50 to-white" x-data="{ showAllRec: false }">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex items-center justify-center text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Recommended For You</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ($recommendations as $i => $product)
                        <template x-if="showAllRec || {{ $i }} < 8">
                            <a href="{{ route('product.show', $product->slug) }}"
                                class="bg-white rounded-xl shadow-sm hover:shadow-md transition flex flex-col overflow-hidden group">
                                <img src="{{ $product->product_image ? asset('storage/product_images/' . $product->product_image) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                    alt="{{ $product->product_name }}" class="w-full h-32 object-cover" />
                                <div class="p-4 flex-1 flex flex-col">
                                    <h3 class="font-semibold text-gray-800 mb-1">{{ $product->product_name }}</h3>
                                    <p class="text-green-600 font-bold mb-2">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <div class="text-xs text-gray-500 mb-2 truncate">
                                        {{ $product->category?->category_name }} &bull; {{ $product->store?->store_name }}
                                    </div>
                                    <button
                                        class="add-to-cart-btn w-full px-3 py-1 rounded bg-green-100 text-green-700 text-xs font-semibold hover:bg-green-200 transition flex items-center justify-center gap-1"
                                        data-name="{{ $product->product_name }}" data-price="{{ $product->price }}"
                                        data-id="{{ $product->id_product }}" data-slug="{{ $product->slug }}"
                                        data-image="{{ $product->product_image ? asset('storage/' . $product->product_image) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                                        onclick="event.stopPropagation(); event.preventDefault();">
                                        <i class="ri-shopping-cart-2-fill"></i> Add to cart
                                    </button>
                                </div>
                            </a>
                        </template>
                    @endforeach
                </div>
                <div class="flex justify-center mt-6">
                    <button @click="showAllRec = !showAllRec"
                        class="flex items-center gap-2 px-5 py-2 rounded-full font-medium text-sm
                            border border-green-600
                            text-green-600
                            bg-white
                            hover:bg-green-50
                            focus:outline-none focus:ring-2 focus:ring-green-400
                            transform
                            duration-300
                            active:scale-95
                            shadow
                            hover:shadow-md">
                        <span x-text="showAllRec ? 'Tampilkan Lebih Sedikit' : 'Lihat Semua'"></span>
                    </button>
                </div>
            </div>
        </section>
    @endif
    <!-- End Langsung-PO Home Dashboard -->
    @if (Auth::check())
        <x-visitor.cart-button></x-visitor.cart-button>
    @endif
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cart badge
        const cartBadge = document.getElementById('cart-badge');
        let cartCount = parseInt(cartBadge?.textContent) || 0;

        // Add to cart buttons
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Get product ID from data attribute
                const productId = this.getAttribute('data-id');

                // 1. Animation
                const productCard = btn.closest('.bg-white');
                const img = productCard.querySelector('img');
                const cartBtn = document.getElementById('cartbutton');

                if (img && cartBtn) {
                    const imgRect = img.getBoundingClientRect();
                    const cartRect = cartBtn.getBoundingClientRect();
                    const flyingImg = img.cloneNode(true);

                    flyingImg.style.position = 'fixed';
                    flyingImg.style.left = imgRect.left + 'px';
                    flyingImg.style.top = imgRect.top + 'px';
                    flyingImg.style.width = imgRect.width + 'px';
                    flyingImg.style.height = imgRect.height + 'px';
                    flyingImg.style.zIndex = 99999;
                    flyingImg.style.transition = 'all 0.8s cubic-bezier(.68,-0.55,.27,1.55)';

                    document.body.appendChild(flyingImg);

                    setTimeout(() => {
                        flyingImg.style.left = (cartRect.left + cartRect.width / 2 -
                            imgRect.width / 4) + 'px';
                        flyingImg.style.top = (cartRect.top + cartRect.height / 2 -
                            imgRect.height / 4) + 'px';
                        flyingImg.style.width = imgRect.width / 2 + 'px';
                        flyingImg.style.height = imgRect.height / 2 + 'px';
                        flyingImg.style.opacity = 0.5;
                    }, 10);

                    setTimeout(() => {
                        flyingImg.remove();
                    }, 850);
                }

                // 2. AJAX Request to add to cart
                fetch(`/customer/cart/add/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: 1
                        })
                    })
                    .then(response => {
                        if (response.status === 401) {
                            // User is not authenticated
                            window.location.href = '{{ route('login') }}?redirect=' +
                                encodeURIComponent(window.location.href);
                            throw new Error('Authentication required');
                        }
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 3. Update cart count on success
                        if (data.cart_count) {
                            cartCount = data.cart_count;
                        } else {
                            cartCount++;
                        }

                        if (cartBadge) {
                            cartBadge.textContent = cartCount;
                            cartBadge.style.display = cartCount > 0 ? 'flex' : 'none';
                        }

                        // Notification
                        const notification = document.createElement('div');
                        notification.className =
                            'fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-[9999] flex items-center gap-2';
                        notification.innerHTML =
                            '<i class="ri-check-line"></i> Product added to cart!';
                        document.body.appendChild(notification);

                        setTimeout(() => {
                            notification.classList.add('opacity-0',
                                'transition-opacity', 'duration-300');
                            setTimeout(() => notification.remove(), 300);
                        }, 2000);
                    })
                    .catch(error => {
                        console.error('Error adding to cart:', error);

                        if (error.message !== 'Authentication required') {
                            // Only show error if it's not the auth redirect
                            const notification = document.createElement('div');
                            notification.className =
                                'fixed bottom-5 left-1/2 transform -translate-x-1/2 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg z-[9999] flex items-center gap-2';
                            notification.innerHTML =
                                '<i class="ri-error-warning-line"></i> Failed to add to cart. Please try again.';
                            document.body.appendChild(notification);

                            setTimeout(() => {
                                notification.classList.add('opacity-0',
                                    'transition-opacity', 'duration-300');
                                setTimeout(() => notification.remove(), 300);
                            }, 2000);
                        }
                    });
            });
        });
    });
</script>
