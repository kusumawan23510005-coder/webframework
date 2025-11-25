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

        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
       // dd($user); 
        return view('user',['data'=> $user]);
    }
}
