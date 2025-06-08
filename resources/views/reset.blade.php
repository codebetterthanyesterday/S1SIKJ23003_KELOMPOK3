@extends('layout')

@section('title', 'Reset Password')

@section('content')

    <div class="bg-white rounded-xl shadow-lg max-w-md w-full p-6">
        <h2 class="text-2xl font-semibold text-gray-800 text-center mb-1">
            Change your password
        </h2>
        <p class="text-sm text-gray-500 text-center mb-6">
            Enter a new password below to change your password
        </p>

        {{-- Pesan sukses --}}
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset.process') }}">
            @csrf
            {{-- Token dan email --}}
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-4">
                <input id="password" type="password" name="password" required placeholder="New password"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
                @error('password')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-6">
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="Confirm your password"
                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
                @error('password_confirmation')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-orange-500 text-white font-semibold uppercase px-4 py-2 rounded hover:bg-orange-600 transition">
                Change Password
            </button>
        </form>
    </div>
@endsection
