<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller {

    function cartPage(){
        $ordersProduct = Session::get('products', []);

        $sum = 0;
        foreach($ordersProduct as $idProduct => &$orderProduct){
            $orderProduct['product'] = Product::find($idProduct);
            if($orderProduct['product']){
                $orderProduct['price'] = $orderProduct['product']->price * $orderProduct['count'];
                $sum += $orderProduct['price'];
            }
        }


        return view('main.cart_page',[
            'ordersProduct' => $ordersProduct,
            'totalSum' => $sum,
            'countCartProducts' => count($ordersProduct)
        ]);
    }

    /*** POST ***/
    function addOrder(){

    }

    /*** POST AJAX ***/
    function addProductToCart(){
        request()->validate([
            'idProduct' => 'required|integer'
        ]);

        $idProduct = request('idProduct');
        $products = Session::get('products', []);

        if(isset($products[$idProduct]))
            $products[$idProduct]['count']++;
        else
            $products[$idProduct] = [
                'count' => 1,
                'params' => request('params',[])
            ];

        Session::put('products', $products);

        return '{"ok":true, "count":'.count($products).'}';
    }
}
