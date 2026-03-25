@extends('admin.base_template')

@push('head')
    <script src="/js/admin/categories.js"></script>
    <script>
        categories = { @foreach($categories as $list)
            @foreach($list as $category)
            {{$category->id}}:
                {
                    caption: "{{$category->caption}}",
                    desc: "{!! strtr($category->description,["\n"=>'<br>',"\r"=>'']) !!}",
                    parent_id: {{$category->parent_id}}
                },
            @endforeach
        @endforeach };
    </script>
@endpush

@section('content')
    <dialog id="categoryDlg" closedby="any">
        <form id="formType" onsubmit="sendCategory(); return false;">
            <input type="hidden" name="idCategory" id="idCategory" value="">
            <table>
                <tr>
                    <td>Название категории</td>
                    <td><input class="form-control" name="caption" id="caption" autocomplete="off"> </td>
                </tr>
                <tr>
                    <td>В какой категории расположен</td>
                    <td><select class="form-control" name="parent_id" id="parent_id">
                        <option value="0">- Нет -</option>
                        @if(count($categories))
                        @include('admin.products.categories.optionCategory', [
                            'categories' => $categories,
                            'list' => $categories[0],
                            'level' => ''
                        ])
                        @endif
                    </select></td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td><textarea class="form-control" name="desc" id="desc" cols=50 rows=20></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn btn-success" type="submit" value="Сохранить категорию"></td>
                </tr>
            </table>
        </form>
    </dialog>

    <section>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Название категории</th>
                    <th>SAF-имя для ссылки</th>
                    <th>Описание</th>
                    <th>
                        <i class="fa fa-cog"></i>
                        <button class="btn btn-success" style="float:right" onclick="openAddCategory()"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @if(count($categories))
                @include('admin.products.categories.trCategory', [
                    'categories' => $categories,
                    'list' => $categories[0],
                    'level' => 0
                ])
                @endif
            </tbody>
        </table>
    </section>
@endsection
