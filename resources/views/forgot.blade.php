@extends('layout')

@section('title', 'Forgot Password')

@section('content')

    {{-- Card putih --}}
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h2 class="text-2xl font-bold text-center text-green-600 mb-2">
            Forgot Password
        </h2>
        <p class="text-center text-gray-600 mb-6">
            Enter your email address and we'll send you a link to reset your password.
        </p>

        {{-- Notifikasi sukses --}}
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('forgot.process') }}">
            @csrf
            <div class="mb-4">
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Your e-mail address"
                    class="w-full px-4 py-2 border border-orange-300 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
                @error('email')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Send
            </button>
        </form>

        {{-- Link kembali ke login --}}
        <p class="text-center text-sm text-gray-500 mt-4">
            <a href="{{ route('login') }}" class="text-green-600 hover:underline">
                Back to Login
            </a>
        </p>
    </div>
@endsection
