<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseController {

    function page(){
        $this->menu->active = "profile";
        return view('admin.users.profile');
    }

    /* POST */
    function saveData(){
        request()->validate([
            "name" => 'required|min:3',
            "email" => 'required|min:4|regex:/^([\w+-]+\.)*[\w+-]+\w@([\w-]+\.){1,3}[\w]{2,}$/i',
        ]);

        $user = Auth::user();
        /** @var User $user */
        $user->forceFill(request()->all(['name','email']))->save();

        return back();
    }

    function savePassword(){
        request()->validate([
            'pass' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();
        /** @var User $user */
        $user->password = request('pass');
        $user->save();
        return back();
    }
}
