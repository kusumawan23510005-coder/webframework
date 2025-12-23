<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if($request->ajax() || $request->wantsJson()){
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil login',
                    'redirect' => url('/')]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Gagal login',
            ]);
            
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }}
