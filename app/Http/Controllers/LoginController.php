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
            $redirectTo = '';
            if (Auth::user()->role == 'admin') {
                $redirectTo = redirect()->intended('/admin/dashboard');
            } elseif (Auth::user()->role == 'customer') {
                $redirectTo = redirect()->intended('/ctm/page/home');
            }
            $request->session()->regenerate();
            return $redirectTo->with('success', 'Login berhasil.');
        }

        return back()->withErrors([
            'login' => 'Username/email atau password salah.',
        ]);
    }
}
