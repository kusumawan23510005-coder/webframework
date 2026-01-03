<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeUser
{
    // Ubah parameter ke-3 menjadi ...$roles (menangkap banyak role)
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user(); // Ambil user login

        if (!$user) {
            abort(403, 'Anda belum login');
        }

        // Cek apakah user punya salah satu dari role yang diizinkan
        // Kita pakai level_kode dari database
        if (in_array($user->level->level_kode, $roles)) {
            return $next($request); // Silakan masuk
        }

        // Jika tidak punya akses
        abort(403, 'Forbidden. Role Anda: ' . $user->level->level_kode);
    }
}
