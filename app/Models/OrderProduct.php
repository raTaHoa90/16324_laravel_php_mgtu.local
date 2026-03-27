<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'order_id',      // ссылка на заказ
    'product_id',    // ссылка на товар
    'count_product', // количество этого товара
    'param_values'   // внесенные параметры товара для заказа
])]
class OrderProduct extends Model {
    public $timestamps = false;
    protected $table = 'order_product';

    function product(): Product{
        return Product::find($this->product_id);
    }
}
