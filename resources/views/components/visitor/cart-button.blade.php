@php
    $cartCount = 0;
    if (Auth::check()) {
        $user = Auth::user();
        $cartCount = App\Models\CartItem::whereHas('cartGroup', function ($query) use ($user) {
            $query->where('id_user', $user->id_user);
        })->sum('quantity');
    }
@endphp

<a href="{{ route('cart.index') }}" id="cartbutton"
    class="fixed z-[9999] cursor-pointer bottom-4 right-4 border-2 border-green-600 text-green-600 bg-[#fbfbfb] rounded-full w-12 h-12 flex items-center justify-center shadow transition hover:bg-green-50
           md:w-14 md:h-14">
    <i class="ri-shopping-cart-fill text-xl md:text-2xl"></i>
    <span id="cart-badge"
        class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"
        style="{{ $cartCount > 0 ? 'display:flex' : 'display:none' }}">{{ $cartCount }}</span>
</a>
