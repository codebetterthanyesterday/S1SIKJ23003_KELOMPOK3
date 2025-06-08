@extends('layout')

@section('title', 'Login')

@section('content')

    <!-- Container Utama: flex-col untuk mobile, flex-row untuk desktop -->
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full max-w-6xl flex flex-col md:flex-row">

        <!-- Section Overlay (Promosi) -->
        <!-- Selalu order-1 agar muncul di bagian atas di mobile dan di sebelah kiri di desktop -->
        <div class="w-full md:w-1/2 relative order-1">
            <!-- Ganti URL gambar sesuai kebutuhan -->
            <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Promotional Image"
                class="object-cover w-full h-64 md:h-full">
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-b from-green-600 to-orange-500 opacity-75"></div>
            <!-- Teks Promosi -->
            <div class="absolute inset-0 flex flex-col justify-center backdrop-blur-[3px] items-center p-8 text-white">
                <h3 class="text-3xl font-bold mb-4">Welcome Back!</h3>
                <p class="text-center text-lg max-w-xs">
                    Log in to your account and continue your journey with us.
                </p>
            </div>
        </div>

        <!-- Section Form Sign In -->
        <!-- Selalu order-2 agar muncul di bawah overlay di mobile dan di sebelah kanan di desktop -->
        <div class="w-full md:w-1/2 p-8 md:p-10 order-2">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-gray-700">Sign In</h2>
                <p class="text-gray-500 mt-2">Enter your credentials to access your account.</p>
            </div>
            @error('login')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $message }}
                </div>
            @enderror
            <form action="{{ route('login.process') }}" method="POST">
                @csrf
                <!-- Input Email/username -->
                <div class="mb-4">
                    <label for="email_username" class="block text-sm font-medium text-gray-700 mb-1">Email Address or Username</label>
                    <input type="text" id="email_username" name="email_username" required placeholder="fathinabr@example.com or fathinabr_"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500">
                </div>
                <!-- Input Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-orange-500">
                </div>
                <!-- Checkbox Remember dan Link Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center text-gray-600 text-sm">
                        <input type="checkbox" name="remember-me" class="custom-checkbox mr-2">
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('forgot') }}" class="text-sm font-medium text-green-500 hover:text-green-600">Forgot
                        Password?</a>
                </div>
                <button type="submit"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-md transition-colors font-semibold">
                    Sign In
                </button>
            </form>

            <p class="text-sm text-gray-500 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-green-500 hover:text-green-600 font-medium">Sign Up</a>
            </p>
        </div>

    </div>
@endsection
