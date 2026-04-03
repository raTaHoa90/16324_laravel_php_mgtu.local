@extends('main.base_template')

@push('head')
    <link rel="stylesheet" href="/css/lightbox.css">
    <script src="/js/lightbox.js"></script>

    <style>
        .images img{
            max-height: 200px;
        }
    </style>

    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    </script>
@endpush

@section('content')

    <section style="float:left">
        <h2>{{$product->caption}}</h2>

        <h3>Изображение товара:</h3>
        <div class="images">
            @foreach ($product->images() as $image)
                <a href="/imgs/{{$image}}"  data-lightbox="product-image" ><img class="-m" src="/imgs/{{$image}}"></a>
            @endforeach
        </div>

        <h3>Информация о товаре:</h3>
        <div class="container">
            <div class="row">
                <div class="col" style="min-width:300px">
                    {!!strtr($product->description, ["\n"=>'<br>'])!!}
                </div>
                <div class="col">
                    <table class='r-t'>
                        <caption style="caption-side: top;">Характеристики</caption>
                        <tr>
                            <td>Цена:</td>
                            <td>{{$product->price ?: 0}} р.</td>
                        </tr>
                    @foreach ($product->params() as $paramName => $param)
                        <tr>
                            <td>{{$paramName}}:</td>
                            <td>{!!$param->getValue()!!}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>

        {{--<tr>
            <td>Статус:</td>
            <td><select class="form-control" name="status" id="status">
            @foreach ($statuses as $statusID => $status)
                <option value="{{$statusID}}" @if(old('status',$product->status) == $statusID) selected @endif >{{$status}}</option>
            @endforeach
            </select></td>
        </tr>--}}
    </section>
@endsection
