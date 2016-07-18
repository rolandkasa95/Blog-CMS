<?php

class Loader
{
    /**
     * Autoloader by namespaces
     */
    public static function init(){
        spl_autoload_register(function ($class){
            $class = 'Classes/' . str_replace('\\', '/', $class) . '.php';
            require_once($class);
        });
    }
}