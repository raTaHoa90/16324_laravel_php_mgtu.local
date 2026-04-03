<?php

namespace App\Http\Menu;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MainMenuRight extends BaseMenu {
    function __construct() {

        $this->AddMenu('Корзина')->icon('fa-shopping-cart')->link('/carts')->id('carts')->span('countProduct');

        $user = Auth::user();
        if($user && !in_array($user->group_role, [User::ROLE_CLIENT, User::ROLE_GUEST, User::ROLE_BANNED]))
            $this->AddMenu('Управление сайтом')->link('/admin')->icon('fa-cogs');

        $this->AddMenu('Вход');
    }
}
