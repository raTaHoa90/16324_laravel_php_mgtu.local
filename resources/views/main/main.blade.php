@extends('main.base_template')

@section('content')
    <section>
        <h2>Добро пожаловать на сайт</h2>
        <div class="-flex-table">
        @foreach ($products as $product)
            @include('main.product_panel', ['product'=>$product])
        @endforeach
        </div>
        {{$products->links()}}
    </section>
@endsection
