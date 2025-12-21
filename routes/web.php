<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController; // Sebaiknya tambahkan ini juga
use App\Http\Controllers\LevelController; 
use App\Http\Controllers\KategoriController; 
use App\Http\Controllers\UserController;


Route::get('/', [UserController::class, 'index']);

// Baris ini sekarang sudah benar karena import di atas sudah diperbaiki

Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          // Halaman awal user
    Route::post('/list', [UserController::class, 'list']);      // Untuk DataTables AJAX

    Route::get('/create', [UserController::class, 'create']);   // Halaman Form Tambah
    Route::post('/', [UserController::class, 'store']);         // Simpan Data Baru (Standard Laravel: POST /user)

    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);

    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);

    Route::get('/{id}', [UserController::class, 'show']);       // Detail User
    Route::get('/{id}/edit', [UserController::class, 'edit']);  // Halaman Form Edit
    Route::put('/{id}', [UserController::class, 'update']);     // Simpan Perubahan (Standard Laravel: PUT /user/{id})
    Route::delete('/{id}', [UserController::class, 'destroy']); // Hapus Data
});

Route::group(['prefix' => 'level'], function () {
    Route::get('/', [LevelController::class, 'index']);          // Halaman awal user
    Route::post('/list', [LevelController::class, 'list']);      // Untuk DataTables AJAX

    Route::get('/create_ajax', [LevelController::class, 'create_ajax']);
    Route::post('/ajax', [LevelController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']);

    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']);


});

Route::group(['prefix' => 'kategori'], function () {
    Route::get('/', [KategoriController::class, 'index']);          // Halaman awal user
    Route::post('/list', [KategoriController::class, 'list']);      // Untuk DataTables AJAX

    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);

    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);

    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
});