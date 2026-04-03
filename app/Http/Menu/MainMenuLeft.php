<?php

namespace App\Http\Menu;

class MainMenuLeft extends BaseMenu {
    function __construct() {

        $catalogMenu = $this->AddMenu('каталог')->icon('fa-archive')->id('catalog')->createSubMenu();
    }
}
