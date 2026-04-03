<?php

use App\Http\Controllers\Admin\{
    AuthController,
    CategoriesController,
    OrderController as AdminOrderController,
    ProductsController,
    ProductsTypesController,
    UsersController
};
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminPanelMiddleware;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () { return view('welcome'); });

Route::controller(MainController::class)->group(function(){
    Route::get('/', 'main');
    Route::get('/products/{product:saf}', 'product');
    Route::get('/categories/{category:saf}', 'category');

});

Route::controller(OrderController::class)->group(function(){
    Route::get('/carts', 'cartPage');

    Route::post('/add-product', 'addProductToCart');
    Route::post('/order-add', 'addOrder');
});


Route::controller(AuthController::class)->prefix('/admin')->group(function(){
    Route::get('/',       'main');
    Route::get('/auth',   'authPage');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout');
});

Route::middleware(['AdminPanel'])->prefix('/admin')->group(function(){

    Route::controller(ProductsTypesController::class)->group(function(){
        Route::get('/products/types', 'table');
        Route::get('/products/types/{paramList}', 'listValues');

        Route::post('/products/types/{paramList}/add', 'listValueAdd');
        Route::post('/products/types/{paramList}/update', 'listValueUpdate');
        Route::post('/products/types/{paramList}/delete', 'listValueDelete');

        Route::post('/products/types/delete', 'delete');
        Route::post('/products/types/create', 'create');
        Route::post('/products/types/rename', 'rename');
    });

    Route::controller(ProductsController::class)->group(function(){
        Route::get('/products/table', 'table');
        Route::get('/products/create', 'createPage');

        Route::get('/products/{product}', 'showPage')->where('product','[0-9]+');

        Route::post('/products/save', 'saveProduct');
    });

    Route::controller(CategoriesController::class)->group(function(){
        Route::get('/products/categories', 'table');

        Route::post('/products/categories/create', 'create');
        Route::post('/products/categories/update', 'update');
        Route::post('/products/categories/delete', 'delete');
    });

    Route::controller(UsersController::class)->group(function(){
        Route::get('/users', 'table');
        Route::post('/users/create-user', 'createUser');
        Route::get('/users/{user:name}', 'user');
    });

    Route::controller(AdminOrderController::class)->group(function(){
        Route::get('/orders', 'table');

        Route::get('/orders/{orderRecord}/set-status', 'setStatus')->where('orderRecord','[0-9]+');
        Route::get('/orders/{orderRecord}', 'order')->where('orderRecord', '[0-9]+');
    });
});


// '/admin/users'
