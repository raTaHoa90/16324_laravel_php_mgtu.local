{{--
    $categories - массив всех категорий
    $list - набор категорий одного уровня, который необходимо отрисовать
    $level - уровень вложенности
--}}
@foreach ($list as $category)
    <option value="{{$category->id}}">{!!$level!!}{{$category->caption}}</option>
    @if(isset($categories[$category->id]))
    @include('admin.products.categories.optionCategory', [
        'categories' => $categories,
        'list' => $categories[$category->id],
        'level' => $level . '&nbsp;&nbsp;&nbsp;&nbsp;'
    ])
    @endif
@endforeach
