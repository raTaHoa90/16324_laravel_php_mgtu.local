@extends('admin.base_template')

@push('head')
    <style>
        .-m{
            max-width: 100px;
            max-height: 100px;
        }
    </style>
    <script src="/js/admin/products.js"></script>
@endpush

@section('content')
    <section>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Имя</th>
                    <th>Тип листа</th>
                    <th>Размер списка</th>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <th>Статус</th>
                    <th>Категория</th>
                    <th>Картинка товара</th>
                    <th>Характеристики</th>
                    <th>
                        <i class="fa fa-cog"></i>
                        <a class="btn btn-success" style="float:right" href="/admin/products/create"><i class="fa fa-plus"></i></a>
                </tr>
            </thead>
            <tbody class="table-group-divider">

                @foreach ($products as $product)
                <tr>
                    <td><a href="/admin/products/{{$product->id}}">{{$product->id}}</a></td>
                    <td><a href="/admin/products/{{$product->id}}">{{$product->caption}}</a></td>
                    <td style="text-align: right">{{$product->price}}</td>
                    <td>{{$product->getStatus()}}</td>
                    <td>{{$product->categoryName()}}</td>
                    <td>@php($img = $product->firstImage())
                        @if($img != '')
                            <img src="/imgs/{{$img}}" class="-m">
                        @endif
                    </td>
                    <td>
                        @foreach($product->params() as $param)
                        <b>{{$param->caption}}</b>: {!! $param->getValue() !!}<br>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links('vendor.pagination.bootstrap-5') }}
    </section>
@endsection
