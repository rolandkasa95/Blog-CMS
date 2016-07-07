<?php

namespace Controllers;

use Views\View;

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

        if(empty($_GET['action'])){
            $view->render('homePage.html');
        }
    }
}