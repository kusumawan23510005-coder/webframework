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

       // $user = UserModel::create(
        //    [
        //        'username' => 'manager35',
        //        'nama' => 'Manager Tiga Lima',
        //        'password' => Hash::make('12345'),
        //        'level_id' => 2,
        //    ]);

        //    $user->username = 'manager46';

        //    $user->isDirty(); //true
        //    $user->isDirty('username'); //true
        //    $user->isDirty('nama'); //false
        //    $user->isDirty(['nama','username']); //true

        //    $user->isClean(); //true
        //    $user->isClean('username'); //true
        //    $user->isClean('nama'); //false
        //    $user->isClean(['nama','username']); //true

        //    $user->save();
        //    $user->isDirty();
        //      $user->isClean();

        //dd($user); 

        $user = UserModel::all();
        return view('user',['data'=> $user]);
    }

     public function tambah()
    {
        return view('user_tambah');
    }


    public function tambah_simpan(Request $request)
    {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah($id)
    {
        $user=UserModel::find(id);
        return view('user_ubah', ['data ' => $user]);
    }

    public function ubah_simpan($id, Request $request)
    {
        $user=UserModel::find(id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make('$request->password');
        $user->level_id = $request->level_id;

        $user->save();
    
        return redirect('/user');
    }

    public function hapus($id)
    {
        $user=UserModel::find(id);
        $user->delete();

         return redirect('/user');
    }

}
