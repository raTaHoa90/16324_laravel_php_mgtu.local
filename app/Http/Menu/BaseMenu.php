<?php

namespace App\Http\Menu;

class BaseMenu implements \IteratorAggregate {
    protected array $menuItems = [];
    public string $active = '';

    function AddMenu($caption): MenuItem {
        $result = new MenuItem;
        $this->menuItems[] = $result;
        return $result->caption($caption);
    }

    function getIterator(): \Traversable {
        return new \ArrayIterator($this->menuItems);
    }

    function isActive(MenuItem $item): bool{
        return $item->isActive($this->active);
    }

    function isActiveByID(string $active): bool {
        foreach($this->menuItems as $item)
            if($item->isActive($active))
                return true;
        return false;
    }
}
