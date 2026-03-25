<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\ParamList;
use App\Models\Product;
use App\Models\ProductParam;

class ProductsController extends BaseController {
    function table(){
        $this->menu->active = 'a_products';

        return view('admin.products.table', [
            'products' => Product::orderBy('id')->paginate(10)
        ]);
    }

    function createPage(){
        $this->menu->active = 'a_products';

        return view('admin.products.edit', [
            'product' => new Product(),
            'statuses' => Product::STATUS,
            'categories' => Category::getAllCategories(),
            'paramTypes' => ProductParam::TYPES,
            'paramTypesList' => ProductParam::TYPES_OF_LIST,
            'TYPE_LIST_VALUES_USER_SELECT' => ProductParam::TYPE_LIST_VALUES_USER_SELECT,
            'lists' => ParamList::all()
        ]);
    }
}
