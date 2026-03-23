<?php

namespace App\Http\Menu;

use Illuminate\Support\Facades\Auth;

class LKMenu extends BaseMenu {
    function __construct() {
        $user = Auth::user();

        if($user != null){
            $this->AddMenu('Выход')->icon('fa-sign-out')->link('/logout');

        } else {
            // меню для гостя
            $this->AddMenu('Вход')->icon('fa-user')->link('/auth');
        }
    }
}
