<?php

namespace App\Http\Controllers;

use App\Mail\OrderProductsMail;
use App\Models\OrderProduct;
use App\Models\OrderRecord;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrderController extends BaseController {

    function cartPage(){
        $this->rightMenu->active = 'carts';
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
        request()->validate([
            'products.*.count' => 'integer',
            'totalSum' => 'required|integer',
            'email' => 'required'
        ]);

        Session::remove('products');

        $reqProducts = request('products', []);
        $email = request('email');
        $address = request('address', '');
        $total = request('totalSum', 0);
        $otherText = request('other', '');

        $order = OrderRecord::create([
            'status' => OrderRecord::STATUS_NEW_ORDER,  // статус заказа
            'count_products' => count($reqProducts), // общее кол-во товара
            'sum_price' => $total,      // общая сумма заказа
            'email' => $email,          // почта покупателя
            'address' => $address,      // адресс доставки
            'other' => $otherText
        ]);

        foreach($reqProducts as $id => $prodAr)
            OrderProduct::create([
                'order_id' => $order->id,      // ссылка на заказ
                'product_id' => $id,    // ссылка на товар
                'count_product' => $prodAr['count'], // количество этого товара
                'param_values' => ''
            ]);

        Mail::to($email)->send(new OrderProductsMail($order));

        return redirect('/');
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
