<?php

namespace App\Http\Menu;

use Traversable;

class BaseMenu implements \IteratorAggregate {
    protected array $menuItems = [];
    public string $active = '';

    function AddMenu($caption): MenuItem {
        $result = new MenuItem;
        $this->menuItems[] = $result;
        return $result->caption($caption);
    }

    function getIterator(): Traversable {
        return new \ArrayIterator($this->menuItems);
    }

    function isActive(MenuItem $item){
        return $this->active == $item->id;
    }
}
