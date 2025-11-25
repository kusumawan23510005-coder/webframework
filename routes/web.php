<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController; // Sebaiknya tambahkan ini juga
use App\Http\Controllers\LevelController; 
use App\Http\Controllers\KategoriController; 
use App\Http\Controllers\UserController; 

Route::get('/', function () {
    return view('welcome');
});

// Baris ini sekarang sudah benar karena import di atas sudah diperbaiki
Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/user/{name?}/alamat/{alamat}', function ($name=null , $alamat=null) {
    return 'Nama saya '.$name. " alamat "  .$alamat;
});

Route::get('/hello',[WelcomeController::class,'hello']); // Ini sudah benar