<?php

namespace App\Http\Menu;

use Illuminate\Support\Facades\Auth;

class AdminMenu extends BaseMenu {
    function __construct() {
        $user = Auth::user();
        if($user === null) return;

        $this->AddMenu('Профиль')->icon('fa-user-o')->link('/admin/profile')->id('profile');
        $this->AddMenu('Пользователи')->icon('fa-users')->link('/admin/users')->id('users');

        $subMenuProject = $this->AddMenu('Товары')->icon('fa-archive')->id('articles')
            ->createSubMenu();

        $subMenuProject->AddMenu('Списки значений')->link('/admin/products/types')->id('a_types');
        $subMenuProject->AddMenu('Категории')->link('/admin/products/categories')->id('a_categories');
        $subMenuProject->AddMenu('Списки товаров')->link('/admin/products/table')->id('a_products');

        $this->AddMenu('Заказы')->icon('fa-shopping-cart')->link('admin/orders')->id('orders');

        $this->AddMenu('Выход')->icon('fa-sign-out')->link('/admin/logout');
    }
}
