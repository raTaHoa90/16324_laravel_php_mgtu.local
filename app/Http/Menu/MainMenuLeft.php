<?php

namespace App\Http\Menu;

class MainMenuLeft extends BaseMenu {

    function add_submenu(int $catID, $categories, BaseMenu $menu){
        foreach($categories[$catID] as $category){
            $m = $menu->AddMenu($category->caption)->link('/categories/'.$category->saf);
            if(isset($categories[$category->id]))
                $this->add_submenu($category->id, $categories, $m->createSubMenu());
        }
    }

    function __construct($categories) {
        $catalogMenu = $this->AddMenu('каталог')->icon('fa-archive')->id('catalog')->createSubMenu();
        $this->add_submenu(0, $categories, $catalogMenu);
    }
}
