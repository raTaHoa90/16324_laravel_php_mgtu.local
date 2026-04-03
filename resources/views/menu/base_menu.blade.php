{{--
    $topMenu : BaseMenu
    $menu : BaseMenu - объект меню, которое необходимо отрисовать
    $stikyLeft : bool - true = прижимать к левому краю подменю, false = к правому
    $cssClass : string - css-класс меню
--}}
@if(!isset($topMenu)) @php($topMenu = $menu) @endif
<ul class="{{$cssClass ?? 'left-menu'}}">
@foreach($menu as $itemMenu)
    @php($isAct = $topMenu->isActive($itemMenu))
    <li><a class="btn {{$itemMenu->isCss() ? $itemMenu->css : 'btn-light'}} {{$isAct ? 'border border-primary text-primary' : ''}}"
        @if(!$isAct && $itemMenu->isLink()) href="{{ $itemMenu->link }}" @endif
        >@if($itemMenu->isIcon())<i class="fa {{ $itemMenu->icon }}"></i>@endif
        {{ $itemMenu->caption }}
        </a>
        @if($itemMenu->hasSubMenu())
            @include('menu.base_menu', [
                'topMenu' => $topMenu,
                'menu' => $itemMenu->getSubMenu(),
                'cssClass' => $stikyLeft ? 'vertical-menu' : 'vertical-menu-r',
                'stikyLeft' => $stikyLeft
            ])
        @endif
    </li>
@endforeach
</ul>
