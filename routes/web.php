<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController; // Sebaiknya tambahkan ini juga
//use App\Http\Controllers\LevelController; 
//use App\Http\Controllers\KategoriController; 
use App\Http\Controllers\UserController;

//Route::get('/', function () {
//    return view('welcome');
//});

// Baris ini sekarang sudah benar karena import di atas sudah diperbaiki

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          // Halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // Untuk DataTables AJAX

    Route::get('/create', [UserController::class, 'create']);   // Halaman Form Tambah
    Route::post('/', [UserController::class, 'store']);         // Simpan Data Baru (Standard Laravel: POST /user)

    Route::get('/{id}', [UserController::class, 'show']);       // Detail User
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // Halaman Form Edit
    Route::put('/{id}', [UserController::class, 'update']);     // Simpan Perubahan (Standard Laravel: PUT /user/{id})
    Route::delete('/{id}', [UserController::class, 'destroy']); // Hapus Data
});