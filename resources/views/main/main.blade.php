@extends('base')

@push('head')
    <link rel="stylesheet" href="/css/main.css">
    <script>
        function addProduct(idProduct){
            $.post('/add-product', {idProduct},function(req){
                if(req.ok)
                    $('#countProduct').text('('+req.count+')');
            }, 'json');
        }
    </script>
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
    <section>
        <h2>Добро пожаловать на сайт</h2>
        <div class="-flex-table">
        @foreach ($products as $product)
            <div onlick="location='/product/{{$product->id}}'">
                @php($img = $product->firstImage())
                <b>{{$product->caption}}</b><br>
                @if($img != '')
                    <img src="/imgs/{{$img}}"><br>
                @endif
                <i>{{$product->price}} руб.</i><br>
                <input class="btn btn-success" type="button" value="Добавить в корзину" onclick="addProduct({{$product->id}})">
            </div>
        @endforeach
        </div>
        {{$products->links()}}
    </section>
@endsection
