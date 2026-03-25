{{--
    $categories - массив всех категорий
    $list - набор категорий одного уровня, который необходимо отрисовать
    $level - уровень вложенности
--}}
@foreach ($list as $category)
    <tr>
        <td>{{$category->id}}</td>
        <td style="padding-left: {{$level * 20}}px">{{$category->caption}}</td>
        <td>{{$category->saf}}</td>
        <td>{!! strtr($category->description,["\n" => '<br>']) !!}</td>
        <td style="text-align: right">
            @if(!$category->hasUsed())
            <a class="btn btn-danger" onclick="deleteCategory({{$category->id}})"><i class="fa fa-trash-o"></i></a>
            @endif

            <a class="btn btn-primary" onclick="openCategoryEditDlg({{$category->id}})"><i class="fa fa-pencil"></i></a>
        </td>
    </tr>
    @if(isset($categories[$category->id]))
    @include('admin.products.categories.trCategory', [
        'categories' => $categories,
        'list' => $categories[$category->id],
        'level' => $level + 1
    ])
    @endif
@endforeach
