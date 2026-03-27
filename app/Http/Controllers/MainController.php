<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class MainController extends Controller {

    function main(){
        return view('main.main',[
            'products' => Product::where('status', Product::STATUS_VISIBLE)->orderBy('id')->paginate(10),
            'countCartProducts' => count(Session::get('products',[]))
        ]);
    }
}
