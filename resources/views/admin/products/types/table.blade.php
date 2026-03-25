@extends('admin.base_template')

@push('head')
    <script src="/js/admin/productTypes.js"></script>
@endpush

@section('content')
    <dialog id="typeEditDlg" closedby="any">
        <form id="formType" onsubmit="sendType(); return false;">
            <input type="hidden" name="idList" value="">
            <table>
                <tr>
                    <td>Название списка</td>
                    <td><input class="form-control" name="caption" id="caption" autocomplete="off"> </td>
                </tr>
                <tr>
                    <td>Тип списка</td>
                    <td><select class="form-control" name="type_list" id="type_list">
                    @foreach ($types as $typeID => $caption)
                        <option value="{{$typeID}}">{{$caption}}</option>
                    @endforeach
                    </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn btn-success" type="submit" value="Сохранить лист"></td>
                </tr>
            </table>
        </form>
    </dialog>

    <section>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Тип листа</th>
                    <th>Размер списка</th>
                    <th>
                        <i class="fa fa-cog"></i>
                        <button class="btn btn-success" style="float:right" onclick="openTypeEditDlg()"><i class="fa fa-calendar-plus-o"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
            @foreach ($lists as $list)
                <tr onclick="location = '/admin/products/types/{{ $list->id }}'" id="list{{ $list->id }}">
                    <td>{{ $list->id }}</td>
                    <td>{{ $list->caption }}</td>
                    <td>{{ $list->type() }}</td>
                    <td width=130 style="text-align: right">{{ $list->countValues() }}</td>
                    <td style="text-align:right">
                        @if(!$list->hasUsed())
                        <a class="btn btn-danger" onclick="deleteList({{$list->id}}); return cancel(event)"><i class="fa fa-trash-o"></i></a>
                        @endif

                        <a class="btn btn-primary" onclick="openTypeEditDlg({{$list->id}}); return cancel(event)"><i class="fa fa-pencil"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
