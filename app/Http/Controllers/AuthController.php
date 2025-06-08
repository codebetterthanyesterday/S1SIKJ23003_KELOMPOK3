<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;


class AuthController extends Controller
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = User::class;
        $this->roleModel = Role::class;
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function forgot()
    {
        return view('forgot');
    }

    public function reset(Request $request, $token = null)
    {
        return view('reset')->with([
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email_username'    => ['required', 'string'],
            'password'          => ['required', 'string'],
        ]);

        $loginInput = $request->input('email_username');

        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field    => $loginInput,
            'password' => $request->input('password')
        ];

        $remember = $request->has('remember-me');

        // tambahkan $remember di Auth::attempt
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $roles = Auth::user()->roles->pluck('role_name')->map(fn($r) => strtolower($r));
            $redirectTo = '';
            if ($roles->contains('admin')) {
                $redirectTo = redirect()->route('admin.dashboard');
            } else {
                $redirectTo = redirect()->route('home');
            }
            return $redirectTo;
        }

        return back()->withErrors([
            'login' => 'Invalid credentials.',
        ]);
    }

    public function doRegister(Request $request)
    {
        $data = $request->validate([
            'username'              => ['required', 'string', 'max:20', 'unique:users,username'],
            'email'                 => ['required', 'string', 'email', 'max:60', 'unique:users,email'],
            'password'              => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
        ]);

        $user = $this->userModel::create([
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if ($this->roleModel::where('role_name', 'customer')->first()) {
            $user->roles()->attach($this->roleModel::where('role_name', 'customer')->first()->id_role);
        }

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login menggunakan akun Anda.');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kirim link reset
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function doReset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) use ($request) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function doChangePassword(Request $request, $id)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        if (!Hash::check($data['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Wrong password');
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function doLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
