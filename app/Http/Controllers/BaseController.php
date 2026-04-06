<?php

namespace App\Http\Controllers;

use App\Http\Menu\BaseMenu;
use App\Http\Menu\MainMenuLeft;
use App\Http\Menu\MainMenuRight;
use App\Models\Category;
use Illuminate\Support\Collection;

class BaseController extends Controller {
    public ?BaseMenu $rightMenu;
    public ?BaseMenu $breadcrumbs;



    function __construct() {

        $this->menu = new MainMenuLeft(Category::getAllCategories());
        view()->share('menu', $this->menu);

        $this->rightMenu = new MainMenuRight;
        view()->share('rightMenu', $this->rightMenu);

        $this->breadcrumbs = new BaseMenu;
        view()->share('breadcrumbs', $this->breadcrumbs);
    }
}
