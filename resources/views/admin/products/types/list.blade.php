@extends('admin.base_template')

@push('head')
    <script src="/js/admin/productListValue.js"></script>
    <script>
        idList = {{$list->id}};
        hasListColor = {{$list->hasColorList() ? 'true' : 'false'}};
        hasListImage = {{$list->hasImageList() ? 'true' : 'false'}};
    </script>
    <style>
        a{cursor: pointer}
        .color-box {
            width: 20px;
            height: 20px;
            border: 1px black solid;
        }
    </style>
@endpush

@section('content')
    <a href="/admin/products/types" class="btn btn-light"><i class="fa fa-arrow-left"></i> Назад к таблице списков</a><br><br>

    <table class='r-t'>
        <tr>
            <td>Название листа:</td>
            <td>{{ $list->caption }}</td>
        </tr>
        <tr>
            <td>Тип листа:</td>
            <td>{{ $list->type() }}</td>
        </tr>
    </table>

    <section>
        <h3>Список значений</h3>
        <button class="btn btn-success" onclick="addListValue()"><i class="fa fa-calendar-plus-o"></i></button>
        <ul id="listUL">
            @foreach ($list->values() as $valueItem)
            <li id="value{{$valueItem->id}}">#{{$valueItem->id}} <span>{{$valueItem->value}}</span>
                <a class="link-primary" onclick="editListValue({{$valueItem->id}})"><i class="fa fa-pencil"></i></a>
                <a class="link-danger" onclick="deleteListValue({{$valueItem->id}})"><i class="fa fa-trash-o"></i></a>
                @if($list->hasColorList())
                    <div class="color-box" style="background-color: {{$valueItem->value}}"></div>
                @endif
                @if($list->hasImageList())
                    <img class="color-box" src="{{$valueItem->value}}">
                @endif
            </li>
            @endforeach
        </ul>
    </section>
@endsection
