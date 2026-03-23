<?php

namespace App\Http\Menu;

use Illuminate\Support\Facades\Auth;

class AdminMenu extends BaseMenu {
    function __construct() {
        $user = Auth::user();
        if($user === null) return;

        $this->AddMenu('Профиль')->icon('fa-user-o')->link('/admin/profile')->id('profile');
        $this->AddMenu('Пользователи')->icon('fa-users')->link('/admin/users')->id('users');
        $this->AddMenu('Товары')->icon('fa-archive')->link('/admin/articles')->id('articles');
        $this->AddMenu('Заказы')->icon('fa-shopping-cart')->link('admin/orders')->id('orders');

        $this->AddMenu('Выход')->icon('fa-sign-out')->link('/admin/logout');
    }
}
