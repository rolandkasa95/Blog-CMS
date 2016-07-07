<?php

namespace Controllers;

/**
 * Class AppController
 * @package Controllers
 */
class AppController
{
    public $view;
    public $model;
    
    public function init(){
        $view = new View();
    }
}