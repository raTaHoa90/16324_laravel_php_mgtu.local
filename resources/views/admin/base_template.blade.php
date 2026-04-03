@extends('base')

@push('head')
    <link rel="stylesheet" href="/css/admin-styles.css">
    <script src="/js/admin/admin.js"></script>
@endpush

@section('menu')
    @include('menu.base_menu', [
        'menu' => $menu,
        'cssClass' =>'left-menu',
        'stikyLeft' => true
    ])
@endsection

@section('base-content')
    @yield('content')
@endsection
