@extends('base')

@push('head')
    <link rel="stylesheet" href="/css/admin-styles.css">
@endpush

@section('menu')
    <ul class="left-menu">
    @foreach($menu as $itemMenu)
        @php($isAct = $menu->isActive($itemMenu))
        <li><a class="btn {{$itemMenu->isCss() ? $itemMenu->css : 'btn-light'}} {{$isAct ? 'border border-primary text-primary' : ''}}"
            @if(!$isAct && $itemMenu->isLink()) href="{{ $itemMenu->link }}" @endif
            >@if($itemMenu->isIcon())<i class="fa {{ $itemMenu->icon }}"></i>@endif
            {{ $itemMenu->caption }}
            </a></li>
    @endforeach
    </ul>
@endsection

@section('base-content')
    @yield('content')
@endsection
