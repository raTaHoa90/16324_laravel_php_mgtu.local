<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController {

    function table(){
        $this->menu->active = 'users';

        return view('admin.users.table', [
            'roles' => User::ROLES,
            'users' => User::orderBy('id')->paginate(10)
        ]);
    }

    function user(User $user){
        $this->menu->active = 'users';

        return view('admin.users.user',[
            'thisUser' => $user
        ]);
    }

    /********  POST  *********/

    function createUser(){
        request()->validate([
            'email' => 'required|email|min:6',
            'name' => 'required|min:3',
            'role' => 'required|integer'
        ]);

        $user = Auth::user();
        if($user === null)
            return '{"error":"Вы не авторизованы"}';

        User::create([
            'email' => request('email'),
            'name' => request('name'),
            'group_role' => request('role'),
            'password' => '123123'
        ]);

        return '{"ok":true}';
    }
}
