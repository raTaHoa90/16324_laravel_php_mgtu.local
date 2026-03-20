<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () { return view('welcome'); });

Route::get('/', [MainController::class, 'main']);

Route::get('/admin',       [AuthController::class, 'main']);
Route::get('/admin/auth',  [AuthController::class, 'authPage']);
Route::post('/admin/login',[AuthController::class, 'login']);
Route::get('/admin/logout',[AuthController::class, 'logout']);
