<?php

class ObjectFactoryService
{
    /**
     * @var array
     */
    public static $config;


    /**
     * Database Configuration retrieval
     *
     * @return array|mixed
     */
    public static function getConfig(){
        if (!self::$config) {
            self::$config = require 'Config/config.php';
        }
        return self::$config;
    }
}