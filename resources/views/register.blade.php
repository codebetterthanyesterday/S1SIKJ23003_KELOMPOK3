@extends('layout')

@section('title', 'Sign Up')

@section('content')
    <!-- Container Utama: flex-col untuk mobile, flex-row untuk desktop -->
    <div class="bg-white my-16 rounded-2xl shadow-2xl overflow-hidden w-full max-w-6xl flex flex-col md:flex-row">

        <!-- Section Overlay (Promosi) -->
        <!-- Urutan: order-1 di mobile (tampil di atas), order-2 di desktop (tampil di sebelah kanan) -->
        <div class="w-full md:w-1/2 relative order-1 md:order-2">
            <!-- Gambar Promosi, dengan tinggi tetap untuk mobile -->
            <img src="https://images.unsplash.com/photo-1467453678174-768ec283a940?q=80&w=1444&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                alt="Promotional Image" class="object-cover w-full h-64 md:h-full">
            <!-- Overlay Gradient dengan kombinasi warna hijau ke jingga -->
            <div class="absolute inset-0 bg-gradient-to-b from-green-600 to-orange-500 opacity-75"></div>
            <!-- Teks Promosi -->
            <div class="absolute inset-0 flex flex-col justify-center backdrop-blur-[3px] items-center p-8 text-white">
                <h3 class="text-3xl font-bold mb-4">Welcome!</h3>
                <p class="text-center text-lg max-w-xs">
                    Order your favorite meals in advance and enjoy fresh, delicious food—ready when you are.
                </p>
            </div>
        </div>

        <!-- Section Form Sign Up -->
        <!-- Urutan: order-2 di mobile (tampil di bawah overlay), order-1 di desktop (tampil di sebelah kiri) -->
        <div class="w-full md:w-1/2 p-8 md:p-10 order-2 md:order-1">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-700">Create Your Account</h2>
                <p class="text-gray-500 mt-2">Join us today! Only few steps to get started.</p>
            </div>
            <!-- Formulir Register -->
            <form action="{{ route('register.process') }}" method="POST">
                @csrf
                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" id="username" name="username" required placeholder="John Doe"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500">
                    @error('username')
                        <span class="text-red-600 text-[0.9rem]">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="email@example.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500">
                    @error('email')
                        <span class="text-red-600 text-[0.9rem]">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500">
                    @error('password')
                        <span class="text-red-600 text-[0.9rem]">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Konfirmasi Password -->
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                        Password</label>
                    <input type="password" id="confirm_password" name="password_confirmation" required
                        placeholder="Confirm your password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500">
                </div>
                <!-- Tombol Submit -->
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-md transition-colors font-semibold">
                    Sign Up
                </button>
            </form>
            
            <p class="text-sm text-gray-500 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-green-500 hover:text-green-600 font-medium">Sign In</a>
            </p>
        </div>

    </div>
@endsection
