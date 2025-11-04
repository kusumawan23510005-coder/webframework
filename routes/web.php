<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/world', function () {
return 'World';
});


Route::get('/posts/{post}/comments/{comment}', function
($postId, $commentId) {
return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
});

Route::get('/user/{name?}/alamat/{alamat}', function ($name=null , $alamat=null) {
return 'Nama saya '.$name. " alamat "  .$alamat;
});

Route::get('/hello',[App\Http\Controllers\WelcomeController::class,'hello']);