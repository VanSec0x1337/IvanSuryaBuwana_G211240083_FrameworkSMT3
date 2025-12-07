<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User_m;

class LoginController extends Controller
{
    /**
     * Handle login authentication
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User_m::where('username', $request->username)->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect('/perpus')->with('success', 'Login berhasil.');
        }

        return back()->withErrors(['login' => 'Username atau password salah.'])->withInput();
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
