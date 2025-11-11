<?php

// ↓↓↓ PERBAIKI BARIS INI ↓↓↓
use App\Http\Controllers\LevelController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController; // Sebaiknya tambahkan ini juga

Route::get('/', function () {
    return view('welcome');
});

// Baris ini sekarang sudah benar karena import di atas sudah diperbaiki
Route::get('/level', [LevelController::class, 'index']);


Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
    return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/user/{name?}/alamat/{alamat}', function ($name=null , $alamat=null) {
    return 'Nama saya '.$name. " alamat "  .$alamat;
});

Route::get('/hello',[WelcomeController::class,'hello']); // Ini sudah benar