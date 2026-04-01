<?php

namespace App\Models;

use App\Policies\OrderPolicy;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(OrderPolicy::class)]
#[Fillable([
    'status',         // статус заказа
    'count_products', // общее кол-во товара
    'sum_price',      // общая сумма заказа
    'email',          // почта покупателя
    'address',        // адресс доставки
    'other',          // примечание к заказу
])]
class OrderRecord extends Model {
    const
        STATUS_NEW_ORDER = 0,
        STATUS_WORK = 1,
        STATUS_TRAVEL = 2,
        STATUS_APPLY = 3,
        STATUS_CANCEL = -1,

        STATUSES = [
            self::STATUS_CANCEL => 'Отменен',
            self::STATUS_NEW_ORDER => 'Новый',
            self::STATUS_WORK => 'Взят в работу',
            self::STATUS_TRAVEL => 'Отправлен',
            self::STATUS_APPLY => 'Выполнен'
        ];

    protected $table = 'order_record';

    function getStatus(): string{
        return static::STATUSES[$this->status] ?? '???';
    }

    function products(){
        return OrderProduct::where('order_id', $this->id)->orderBy('id')->get();
    }
}
