<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () { return view('welcome'); });

Route::get('/', [MainController::class, 'main']);

Route::group(['prefix' => '/admin'], function(){
    Route::controller(AuthController::class)->group(function(){
        Route::get('/',       'main');
        Route::get('/auth',   'authPage');
        Route::post('/login', 'login');
        Route::get('/logout', 'logout');
    });

    Route::controller(UsersController::class)->group(function(){
        Route::get('/users', 'table');
        Route::post('/users/create-user', 'createUser');
        Route::get('/users/{user:name}', 'user');
    });
});


// '/admin/users'
