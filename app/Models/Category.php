<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'caption',     // имя категории
    'saf',         // транслит имени на латинские буквы для красивого имени адреса
    'parent_id',   // вышестоящая категория, в которую вложена текущая или 0, если эта категория самая верхняя.
    'description'  // описание категории
])]
class Category extends Model {
    use SoftDeletes;

    // получить категорию, в которой находится текущая категория, если она не самая верхняя
    function parent(): ?Category {
        if($this->parent_id)
            return null;
        return static::find($this->parent_id);
    }

    // получить все категории которые находятся внутри текущей категории
    function children(string $fieldForSort = 'id') {
        return static::where('parent_id', $this->id)->orderBy($fieldForSort)->get();
    }
}
