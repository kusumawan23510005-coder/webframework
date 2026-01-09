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
    // --- 1. HALAMAN LOGIN ---
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    // --- 2. PROSES LOGIN (AJAX) ---
    public function postLogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {

            // Validasi input
            $credentials = $request->only('username', 'password');

            // Cek kredensial
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil, Anda akan dialihkan...',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal. Username atau password salah.'
            ]);
        }

        return redirect('login');
    }

    // --- 3. PROSES LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

    // --- 4. HALAMAN REGISTER ---
    public function register()
    {
        $levels = LevelModel::all(); // Ambil data level untuk dropdown
        return view('auth.register', ['levels' => $levels]);
    }

    // --- 5. PROSES REGISTER (AJAX - BAGIAN INI YANG KITA PERBAIKI) ---
    public function postRegister(Request $request)
    {
        // Cek apakah request berupa AJAX (Sesuai template AdminLTE Anda)
        if ($request->ajax() || $request->wantsJson()) {

            // A. Validasi Input
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:3|unique:m_user,username', // Cek unik di tabel m_user
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:5',
                'level_id' => 'required|integer'
            ]);

            // Jika Validasi Gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // B. Simpan ke Database
            try {
                UserModel::create([
                    'username' => $request->username,
                    'nama'     => $request->nama,
                    'password' => Hash::make($request->password), // Wajib di-Hash!
                    'level_id' => $request->level_id
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Register Berhasil! Silakan Login.',
                    'redirect' => url('login') // Arahkan ke halaman login setelah sukses
                ]);
            } catch (\Exception $e) {
                // Jika error database (misal koneksi putus atau kolom salah)
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('register');
    }
}
