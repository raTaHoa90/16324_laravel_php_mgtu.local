<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'caption',    // название списка значений
    'type_values' // 0 - список текстовых значений, 1 - список цветов, 2 - набор картинок
])]
class ParamList extends Model {
    const
        TYPE_TEXT_LIST = 0,
        TYPE_COLOR_LIST = 1,
        TYPE_IMAGE_LIST = 2,

        TYPES = [
            self::TYPE_TEXT_LIST  => 'Текстовый список',
            self::TYPE_COLOR_LIST => 'Список цветов',
            self::TYPE_IMAGE_LIST => 'Список картинок'
        ];

    function values(){
        return ParamListValue::where('list_id', $this->id)->orderBy('id')->get();
    }

    function countValues(): int {
        return ParamListValue::where('list_id', $this->id)->count();
    }

    function hasValueItem(string $value): bool{
        return ParamListValue::where([
            'list_id' => $this->id,
            'value' => $value
        ])->count() > 0;
    }

    function addValue(string $value): ParamListValue{
        return ParamListValue::create([
            'list_id' => $this->id,
            'value' => $value
        ]);
    }

    function delValue(string $value){
        ParamListValue::Where([
            'list_id' => $this->id,
            'value' => $value
        ])->delete();
    }

    function type(){
        return static::TYPES[$this->type_values] ?? '???';
    }

    function hasUsed(): bool {
        // SELECT count(*) FROM product_params WHERE list_id = ? AND type_param IN (?, ?)
        $count = ProductParam::where('list_id', $this->id)
            ->whereIn('type_param', ProductParam::TYPES_OF_LIST)
            ->count();
        return $count > 0;
    }

    function hasColorList(): bool {
        return $this->type_values == static::TYPE_COLOR_LIST;
    }

    function hasImageList(): bool {
        return $this->type_values == static::TYPE_IMAGE_LIST;
    }

    function getValueByID($id): string{
        $param = ParamListValue::where([
            'list_id' => $this->id,
            'id' => $id
        ])->first();

        if(!$param)
            return '';

        switch($this->type_values){
            case static::TYPE_TEXT_LIST:
                return $param->value;

            case static::TYPE_COLOR_LIST:
                return '<div style="width:32px;height:32px;background:'.$param->value.';display:inline-block;"></div>';

            case static::TYPE_IMAGE_LIST:
                return '<img src="'.$param->value.'" style="width:32px;height:32px;display:inline-block;">';

            default:
                return '';
        }
    }
}
