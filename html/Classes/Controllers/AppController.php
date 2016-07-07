<?php

namespace Controllers;

use Models\articlepageModel;
use Models\homepageModel;
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
            $this->model = new homepageModel();
            $view->render('homePage.php',$this->model);
        }
        if('articleShow' === $_GET['action']){
            $this->model = new articlepageModel();
            $view->render('articlePage.php',$this->model);
        }
    }
}