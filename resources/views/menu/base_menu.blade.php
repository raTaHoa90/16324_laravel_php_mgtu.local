{{--
    $topMenu : BaseMenu
    $menu : BaseMenu - объект меню, которое необходимо отрисовать
    $stikyLeft : bool - true = прижимать к левому краю подменю, false = к правому
    $offset: bool      - нужно сделать отступ
    $cssClass : string - css-класс меню
    $isTopMenu: bool - является верхним меню
--}}
@if(!isset($topMenu)) @php($topMenu = $menu) @endif
@if(!isset($offset)) @php($offset = false) @endif
@if(!isset($isTopMenu)) @php($isTopMenu = true) @endif

<ul class="{{$cssClass ?? 'left-menu'}}"
    @if($offset)
        @if($stikyLeft)
            style="left:100%; top: 0"
        @else
            style="left:-100%; top: 0"
        @endif
    @endif

>
@foreach($menu as $itemMenu)
    @php($isAct = $topMenu->isActive($itemMenu))
    <li><a class="btn {{$itemMenu->isCss() ? $itemMenu->css : 'btn-light'}} {{$isAct ? 'border border-primary text-primary' : ''}}"
        @if(!$isAct && $itemMenu->isLink()) href="{{ $itemMenu->link }}" @endif
        >@if($itemMenu->isIcon())<i class="fa {{ $itemMenu->icon }}"></i>@endif
        {{ $itemMenu->caption }}
        @if($itemMenu->isSpan())
        <span id="{{$itemMenu->span}}"></span>
        @endif
        </a>
        @if($itemMenu->hasSubMenu())
            @include('menu.base_menu', [
                'topMenu' => $topMenu,
                'menu' => $itemMenu->getSubMenu(),
                'cssClass' => $stikyLeft ? 'vertical-menu' : 'vertical-menu-r',
                'stikyLeft' => $stikyLeft,
                'offset' => !$isTopMenu,
                'isTopMenu' => false
            ])
        @endif
    </li>
@endforeach
</ul>
