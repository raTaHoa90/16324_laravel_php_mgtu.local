<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'list_id',  // ссылка на список значений
    'value'     // значение в списке
])]
class ParamListValue extends Model {
    protected $table = 'param_list_values';
}
