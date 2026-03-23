<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'product_id', // для какого товара заводится характеристика
    'caption',    // название характеристики
    'value',      // значение характеристики
    'type_param', // тип характеристики
    'list_id'     // ссылка на лист значений, если выбран соответствующий тип
])]
class ProductParam extends Model {
    const
        TYPE_TEXT = 0, // текст
        TYPE_LIST_VALUES = 1, // лист значений
        TYPE_LIST_VALUES_USER_SELECT = 2, // лист значений, который выбирает сам пользователь

        TYPES = [
            self::TYPE_TEXT => 'Любое значение',
            self::TYPE_LIST_VALUES => 'Значение из списка вариантов',
            self::TYPE_LIST_VALUES_USER_SELECT => 'Значения из списка вариантов, которые может выбрать пользователь'
        ],
        TYPES_OF_LIST = [self::TYPE_LIST_VALUES_USER_SELECT, self::TYPE_LIST_VALUES];

    protected $table = 'product_params';

    // возвражает товар, к которому относится параметр
    function product(): Product {
        return Product::find($this->product_id);
    }

    // возвращает список значений, если выбран тип листа
    function list(): ?ParamList {
        if(!in_array($this->type_param, static::TYPES_OF_LIST) ||
            $this->list_id == 0
        ) return null;

        return ParamList::find($this->list_id);
    }
}
