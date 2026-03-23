<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Menu\AdminMenu;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller {
    function __construct() {
        $this->menu = new AdminMenu();
        view()->share('menu', $this->menu);

        $user = Auth::user();
        view()->share('user', $user);
    }
}
