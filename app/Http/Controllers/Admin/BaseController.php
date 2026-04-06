<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Menu\AdminMenu;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller {
    public ?User $user = null;
    function __construct() {
        $this->menu = new AdminMenu();
        view()->share('menu', $this->menu);

        $this->user = Auth::user();
        view()->share('user', $this->user);
    }
}
