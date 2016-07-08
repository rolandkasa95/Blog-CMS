<?php

namespace Controllers;

use Models\articlepageModel;
use Models\homepageModel;
use Models\tagpageModel;
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

        if( !isset($_GET['action']) || empty($_GET['action']) ){
            $this->model = new homepageModel();
            $view->render('homePage.php',$this->model);
        }
        if( isset($_GET['action']) && 'articleShow' === $_GET['action']){
            $this->model = new articlepageModel();
            $view->render('articlePage.php',$this->model);
        }
        if( isset($_GET['action']) && 'tag' === $_GET['action']){
            $this->model = new tagpageModel();
            $view->render('tagPage.php',$this->model);
        }

    }
}