<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        /*$data=[
            'username' => 'customer-1',
            'nama' => 'Pelanggan',
            'password' => Hash::make('password'),
            'level_id' => 4
        ];
        Usermodel::insert($data);*/

        $user = UserModel::all();
        return view('user',['data'=> $user]);
    }
}
