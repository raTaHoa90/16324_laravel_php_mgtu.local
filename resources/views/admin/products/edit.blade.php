@extends('admin.base_template')

@push('head')
    <script src="/js/admin/products.js"></script>
    <style>
        section{
            margin-right: 10px;

            & > table, & > form > table{
                width: 700px;

                & .r-t{
                    min-width: 100%;
                }
            }
        }
        .hide {
            display: none;
        }
        .form-control{
            margin-bottom: 10px;
        }
    </style>
    <script>
        paramTypesList = [ @foreach($paramTypesList as $paramTypeID)
            {{$paramTypeID}},
        @endforeach ];

        lists = {
        @foreach ($lists as $list)
            {{$list->id}}: [ @foreach ($list->values() as $item)
                {id: {{$item->id}}, caption: "{{$item->value}}" },
            @endforeach],
        @endforeach
        };

        params = {
        @foreach ($product->params() as $paramName => $param)
            "{{$paramName}}": {
                id: "{{$param->id}}",
                caption: "{{$paramName}}",
                type: "{{$param->type_param}}",
                value: "{{$param->value}}",
                listId: "{{$param->list_id}}"
            }
        @endforeach
        }

        TYPE_LIST_VALUES_USER_SELECT = {{$TYPE_LIST_VALUES_USER_SELECT}};

        $(function(){
            drawParams();
        });
    </script>
@endpush

@section('content')
    <dialog id="paramDlg" closedby="any">
        <input type="hidden" id="idParam" value="">
        <table>
            <tr>
                <td>Название параметра</td>
                <td><input class="form-control" id="caption" autocomplete="off"> </td>
            </tr>
            <tr>
                <td>Тип параметра</td>
                <td><select class="form-control" id="paramType" onchange="paramTypeChange(this, event)">
                @foreach ($paramTypes as $typeID => $caption)
                    <option value="{{$typeID}}">{{$caption}}</option>
                @endforeach
                </select></td>
            </tr>
            <tr>
                <td>Значение</td>
                <td>
                    <div id="typeText" class="hide">
                        <input class="form-control" id="textValue">
                    </div>
                    <div id="typeList" class="hide">
                        <select class="form-control" id="list" onchange="listChange(this, event)">
                            <option value="0">- не выбран -</option>
                        @foreach ($lists as $list)
                            <option value="{{$list->id}}">{{$list->caption}}</option>
                        @endforeach
                        </select>

                        <select class="form-control" id="listValues"></select>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="btn btn-success" type="button" value="Сохранить" onclick="paramSet()"></td>
            </tr>
        </table>
    </dialog>


    <a href="/admin/products/table" class="btn btn-light"><i class="fa fa-arrow-left"></i> Назад к таблице товаров</a>
    <input form="saveProduct" class="btn btn-success" type="submit" value="Сохранить">
    <br><br>

    <form action="?" method="POST" name="saveProduct" id="saveProduct" enctype="multipart/form-data">

        <section style="float:left">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">

                <table class='r-t'>
                <tr>
                    <td>Название товара:</td>
                    <td><input class="form-control" name="caption" id="caption" value="{{old('caption', $product->caption)}}"></td>
                </tr>
                <tr>
                    <td>Описание:</td>
                    <td><textarea name="desc" id="desc" class="form-control" rows=20 cols=50>{{old('desc', $product->description)}}</textarea></td>
                </tr>
                <tr>
                    <td>Цена:</td>
                    <td><input class="form-control" type="number" name="price" id="price" value="{{old('price', $product->price)}}"></td>
                </tr>
                <tr>
                    <td>В какой категории расположен</td>
                    <td><select class="form-control" name="category_id" id="category_id">
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
                    <td>Статус:</td>
                    <td><select class="form-control" name="status" id="status">
                    @foreach ($statuses as $statusID => $status)
                        <option value="{{$statusID}}" @if(old('status',$product->status) == $statusID) selected @endif >{{$status}}</option>
                    @endforeach
                    </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </section>

        <section>
            <table class='r-t'>
                <tr>
                    <td>Картинки товара:</td>
                    <td><input class="form-control" type="file" multiple accept=".jpg,.jpeg,.png,.webp,.svg" class="form-control" name="caption" id="caption" value="{{old('caption', $product->caption)}}"></td>
                </tr>
                <tr>
                    <td>Характеристики товара:</td>
                    <td>
                        <button type="button" class="btn btn-success" onclick="addParamDlg()"><i class="fa fa-plus"></i></button>
                        <table class='r-t'>
                            <tr>
                                <th>Характеристика</th>
                                <th>Тип</th>
                                <th>Значение</th>
                                <th>список</th>
                                <th></th>
                            </tr>
                            <tbody id="params">

                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </section>
    </form>
@endsection
