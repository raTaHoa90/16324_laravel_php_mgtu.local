<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'caption',    // название товара
    'description',// описание товара
    'price',      // стоимость товара
    'status',     // статус товара (0 - скрыто, 1 - опубликовано)
    'category_id' // ссылка на категорию в которой располагается товар
])]
class Product extends Model {
    use SoftDeletes;

    const
        STATUS_HIDDEN = 0,  // товар скрыт
        STATUS_VISIBLE = 1, // товар показывается в магазине
        STATUS_IS_OUT_OF_STOCK = 2, // товар закончился

        STATUS = [
            self::STATUS_HIDDEN => 'Скрыт',
            self::STATUS_VISIBLE => 'Показывать',
            self::STATUS_IS_OUT_OF_STOCK => 'Закончился'
        ];

    private $_params = null;

    function category(): ?Category {
        if($this->category_id == 0)
            return null;
        return Category::find($this->category_id);
    }

    function params(){
        if($this->_params === null){
            $params = ProductParam::where('product_id', $this->id)->get();
            $this->_params = [];
            foreach($params as $param)
                $this->_params[$param->caption] = $param;
        }
        return $this->_params;
    }

    function addParam(string $caption, int $type, $listID = 0){
        $params = $this->params();
        $param = $params[$caption] ?? null;
        if($param === null) {
            $param = ProductParam::create([
                'caption' => $caption,
                'product_id' => $this->id,
                'type_param' => $type,
                'list_id' => $listID,
                'value' => ''
            ]);
            $this->_params[$caption] = $param;
            return;
        }

        // если указанная характеристика у товара уже есть
        $param->forceFill([
            'type_param' => $type,
            'list_id' => $listID,
            'value' => ''
        ])->save();
    }

    function setParam(string $caption, string $value){
        $params = $this->params();
        $param = $params[$caption] ?? null;
        if($param !== null){
            $param->value = $value;
            $param->save();
        }
    }

    function delParam(string $caption){
        $params = $this->params();
        if(isset($params[$caption])){
            $params[$caption]->delete();
            unset($this->_params[$caption]);
        }
    }
}
