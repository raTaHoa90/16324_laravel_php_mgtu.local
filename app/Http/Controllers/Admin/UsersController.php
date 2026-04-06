<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsersController extends BaseController {

    function getRolesAndSetMenu(){
        $this->menu->active = 'users';

        $roles = User::ROLES;
        unset($roles[User::ROLE_CLIENT]);
        unset($roles[User::ROLE_GUEST]);
        if($this->user->group_role != User::ROLE_ADMINISTRATOR)
            unset($roles[User::ROLE_ADMINISTRATOR]);

        return $roles;
    }

    //===================

    function table(){
        return view('admin.users.table', [
            'roles' => $this->getRolesAndSetMenu(),
            'users' => User::orderBy('id')->paginate(10)
        ]);
    }

    function user(User $user){
        return view('admin.users.user',[
            'roles' => $this->getRolesAndSetMenu(),
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

        $email = request('email');
        $pass = '123123'; //Str::random(16);
        User::create([
            'email' => $email,
            'name' => request('name'),
            'group_role' => request('role'),
            'password' => $pass
        ]);

        //Mail::to($email)->send(new UserCreaterMail($pass));

        return '{"ok":true}';
    }

    function setRole(){
        request()->validate([
            'uid' => 'required|integer',
            'rid' => 'required|integer'
        ]);

        if(!$this->user->can('menu-users', User::class))
            return '{"error":"У вас нет доступа на эту операцию"}';

        $user = User::find(request('uid'));
        if(!$user)
            return '{"error":"Пользователь под таким ID не существует"}';

        if($user->NotUseAdminPanel())
            return '{"error":"Пользователь не является сотрудником"}';

        if($user->id == $this->user->id)
            return '{"error":"Вы не можете изменить свою роль"}';

        $rid = request('rid');
        if($this->user->group_role != User::ROLE_ADMINISTRATOR && $rid == User::ROLE_ADMINISTRATOR)
            return '{"error":"Вы не можете установить эту роль"}';

        if(in_array($rid,[User::ROLE_GUEST, User::ROLE_CLIENT]))
            return '{"error":"Вы не можете установить эту роль"}';

        $user->group_role = $rid;
        $user->save();

        return '{"ok":true}';
    }
}
