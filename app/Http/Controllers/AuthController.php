<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserModel;
use App\Models\LevelModel;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        // Pastikan request adalah AJAX
        if ($request->ajax() || $request->wantsJson()) {

            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil, Anda akan dialihkan...',
                    'redirect' => url('/') // Ubah url('/') sesuai halaman dashboard Anda
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal. Username atau password salah.'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    // ... Method Register Anda (tidak berubah) ...
    public function register()
    {
        $levels = LevelModel::all();
        return view('auth.register', ['levels' => $levels]);
    }

    // ... postRegister Anda (tidak berubah) ...
}
