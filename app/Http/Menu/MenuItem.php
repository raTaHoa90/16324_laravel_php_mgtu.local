<?php

namespace App\Http\Menu;

use Traversable;

class MenuItem implements \IteratorAggregate {
    const FIELDS = ['caption', 'icon', 'link', 'css', 'id', 'span'];
    /*
    public string $caption; // текст меню
    public string $icon;    // иконка меню
    public string $link;    // ссылка
    public string $css;     // дополнительны CSS-классы
    public string $id;      // ID элемента меню
    public string $span;    // ID поля для индикатора чисел
    */
    protected array $_fields = [];
    protected ?BaseMenu $_subMenu = null;

    function createSubMenu(): BaseMenu {
        $this->_subMenu = new BaseMenu;
        return $this->_subMenu;
    }

    function getSubMenu(): BaseMenu {
        return $this->_subMenu;
    }

    function hasSubMenu(): bool {
        return $this->_subMenu !== null;
    }

    function isActive(string $active): bool {
        return ($this->id && $this->id === $active) ||
            ($this->_subMenu !== null && $this->_subMenu->isActiveByID($active));
    }

    function getIterator(): Traversable {
        return $this->_subMenu->getIterator();
    }

    function __call($name, $arguments){
        $name = strtolower($name);
        if(substr($name, 0, 2) == 'is')
            $testField = 2;
        elseif(substr($name, 0, 3) == 'has')
            $testField = 3;
        else
            $testField = 0;

        // если мы хотим проверить добавлялось ли указанное поле
        if($testField)
            return array_key_exists(
                substr($name, $testField),
                $this->_fields
            );

        // если мы хотим получить или изменить значение поля
        if(count($arguments)){
            if(in_array($name, static::FIELDS))
                $this->_fields[$name] = $arguments[0];
            return $this;
        } elseif(array_key_exists($name, $this->_fields))
            return $this->_fields[$name];

        throw "Метод $name не существует для ".(static::class);
    }

    function __get($name){
        $name = strtolower($name);
        if(in_array($name, static::FIELDS))
            return $this->_fields[$name] ?? '';

        throw "Поле $name не существует для ".(static::class);
    }
}
