@extends('main.base_template')

@section('content')
    <section>
        <h2>Категория: {{$category->caption}}</h2>
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
