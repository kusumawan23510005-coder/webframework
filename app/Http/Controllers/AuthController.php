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
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil login',
                    'redirect' => url('/')
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Gagal login'
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

    // --- FITUR REGISTER ---

    public function register()
    {
        // Ambil data level untuk dropdown
        $levels = LevelModel::all();
        return view('auth.register', ['levels' => $levels]);
    }

    public function postRegister(Request $request)
    {
        // Validasi
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|max:20|unique:m_user,username',
            'nama'     => 'required|max:100',
            'password' => 'required|min:6|confirmed', 
            'level_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ]);
        }

        // Simpan
        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);

        return response()->json([
            'status'   => true,
            'message'  => 'Registrasi Berhasil! Silakan Login.',
            'redirect' => url('login')
        ]);
    }
}
