@extends('base')

@push('head')
    <link rel="stylesheet" href="/css/admin-styles.css">
    <script src="/js/admin/admin.js"></script>
@endpush

@section('menu')
    <ul class="left-menu">
    @foreach($menu as $itemMenu)
        @php($isAct = $menu->isActive($itemMenu))
        <li><a class="btn {{$itemMenu->isCss() ? $itemMenu->css : 'btn-light'}} {{$isAct ? 'border border-primary text-primary' : ''}}"
            @if(!$isAct && $itemMenu->isLink()) href="{{ $itemMenu->link }}" @endif
            >@if($itemMenu->isIcon())<i class="fa {{ $itemMenu->icon }}"></i>@endif
            {{ $itemMenu->caption }}
            </a>
            @if($itemMenu->hasSubMenu())
            <ul class="vertical-menu">
            @foreach($itemMenu as $subItemMenu)
                @php($isSubAct = $menu->isActive($subItemMenu))
                <li><a class="btn {{$subItemMenu->isCss() ? $subItemMenu->css : 'btn-light'}} {{$isSubAct ? 'border border-primary text-primary' : ''}}"
                @if(!$isSubAct && $subItemMenu->isLink()) href="{{ $subItemMenu->link }}" @endif
                >@if($subItemMenu->isIcon())<i class="fa {{ $subItemMenu->icon }}"></i>@endif
                {{ $subItemMenu->caption }}
                </a>
            @endforeach
            </ul>
            @endif
        </li>
    @endforeach
    </ul>
@endsection

@section('base-content')
    @yield('content')
@endsection
