@extends('base')

@push('head')
    <style>
        .-m {
            max-width: 200px;
            max-height: 200px;
        }
    </style>
@endpush

@section('menu')
    <ul class="left-menu">
        <li><a class="btn btn-light"><i class="fa fa-archive"></i> каталог</a></li>
        <li>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
            </div>
        </li>
    </ul>

    <ul class="right-menu">
        <li><a class="btn btn-light" href="/carts"><i class="fa fa-shopping-cart"></i> Корзина <span id="countProduct">@if($countCartProducts)({{$countCartProducts}})@endif </span></a></li>
        <li><a class="btn btn-light"><i class="fa fa-user"></i> войти</a></li>
    </ul>
@endsection

@section('base-content')
<form action="/order-add" method="POST">
    @csrf
    <table class="table">
        <tr>
            <th>Наименование товара</th>
            <th>Картинка товара</th>
            <th>Параметры товара</th>
            <th>Кол-во</th>
            <th>Стоимость</th>
        </tr>
        @foreach($ordersProduct as $id => $orderProd)
        <tr id="prod_{{$id}}">
            <td>{{$orderProd['product']->caption ?? ''}}</td>
            <td>@php($img = $orderProd['product']->firstImage())
                @if($img != '')<img class="-m" src="/imgs/{{$img}}">@endif
            </td>
            <td>
                @foreach($orderProd['product']->params() as $param)
                <b>{{$param->caption}}</b>: {!! $param->getValue() !!}<br>
                @endforeach
            </td>
            <td style="text-align: right">
                <input type="button" class="btn btn-success" value="-"
                >&nbsp<input id="count_prod_{{$id}}" type="number"
                    name="products[{{$id}}][count]"
                    value="{{$orderProd['count']}}"
                    maxlength="3"
                    style="width: 50px; text-align:right"
                >&nbsp<input type="button" class="btn btn-success" value="+">
            </td>
            <td style="text-align: right"><span id="price_prod_{{$id}}">
                {{$orderProd['price']}}
            </span> руб.</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"></td>
            <td>Итого:</td>
            <td style="text-align: right">
                <input type="hidden"  id="price_total_input_{{$id}}" name="totalSum" value="{{$totalSum}}">
                <span id="price_total_{{$id}}">{{$totalSum}}</span> руб.</td>
        </tr>
    </table>

    Укажите свою почту: <input required class="form-control" type="email" name="email" value="{{old('email', '')}}"><br>
    Укажите адресс доставки: <input class="form-control" name="address" value="{{old('address','')}}"><br>
    Укажите особенность заказа или дополнительные комментарии:<br>
    <textarea class="form-control" name="other">{{old('other')}}</textarea><br><br>

    <input class="btn btn-success" type="submit" value="Заказать">
</form>
@endsection
