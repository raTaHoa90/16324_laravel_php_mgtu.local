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
    {{--<li><a class="btn btn-light"><i class="fa fa-archive"></i> каталог</a></li>--}}
    @include('menu.base_menu', [
        'menu' => $menu,
        'cssClass' =>'left-menu',
        'stikyLeft' => true
    ])

    {{--<div class="input-group">
        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
        <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
    </div>--}}

    @include('menu.base_menu', [
        'menu' => $rightMenu,
        'cssClass' =>'right-menu',
        'stikyLeft' => false
    ])
@endsection

@section('base-content')
    @if($breadcrumbs)
    @foreach($breadcrumbs as $itemMenu)
        <a class="btn {{$itemMenu->isCss() ? $itemMenu->css : 'btn-light'}}"
            @if($itemMenu->isLink()) href="{{ $itemMenu->link }}" @endif
            ><i class="fa {{ $itemMenu->isIcon() ? $itemMenu->icon : 'fa-arrow-left' }}"></i>
            {{ $itemMenu->caption }}
        </a>
    @endforeach
    <br><br>
    @endif

    @yield('content')
@endsection
