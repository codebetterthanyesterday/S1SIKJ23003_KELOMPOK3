<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // validasi
        $request->validate([
            'email_username'    => ['required', 'string'],
            'password'          => ['required', 'string'],
        ]);

        $loginInput = $request->input('email_username');

        // tentukan field: jika valid email, pakai 'email', else 'username'
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field    => $loginInput,
            'password' => $request->input('password')
        ];

        // baca checkbox remember
        $remember = $request->has('remember-me');

        // tambahkan $remember di Auth::attempt
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $roles = Auth::user()->roles->pluck('role_name')->map(fn($r) => strtolower($r));
            $redirectTo = '';
            if ($roles->contains('admin')) {
                $redirectTo = redirect()->intended('/admin/dashboard');
            } else {
                $redirectTo = redirect()->intended('/');
            }
            // return $redirectTo;
            return $redirectTo->with('success', 'Login berhasil.');
        }

        return back()->withErrors([
            'login' => 'Username/email atau password salah.',
        ]);
    }
}
