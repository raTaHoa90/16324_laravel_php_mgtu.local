<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController {

    function main(){
        $user = Auth::user();
        if($user === null)
            return redirect('/admin/auth');

        return view('admin.main');
    }

    function authPage(){
        return view('admin.auth');
    }

    function logout(){
        Auth::logout();
        return redirect('/admin');
    }

    // POST

    function login(){
        request()->validate([
            'login' => 'required|min:3|email',
            'pass' => 'required|min:6'
        ]);

        if(Auth::attempt(['email'=> request('login'), 'password' => request('pass')])){
            request()->session()->regenerate();
            return redirect('/admin');
        }

        return back()->withErrors([
            'email' => 'указанный пользователь не существует или неправвильно введен пароль'
        ])->onlyInput('login');
    }

}
