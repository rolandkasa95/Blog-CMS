<?php

namespace Controllers;

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
            $model = new homepageModel();
            $result = $model->getArticles();
            $view->render('homePage.php',$model);
        }
    }
}