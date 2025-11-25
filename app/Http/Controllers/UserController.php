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
            'level_id' => 2,
            'username' => 'manager_tiga',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345'),
            
        ];
        Usermodel::create($data);*/

        $user = UserModel::findOrFail(1); 
        return view('user',['data'=> $user]);
    }
}
