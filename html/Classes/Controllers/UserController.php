<?php

namespace Controllers;


use Views\View;

class UserController
{
    public $view;
    
    public function init()
    {
        if (isset($_GET['action'])){
            if('login' === $_GET['action']){
                $class = new UserModel();
                $class->validate($_GET);
                $class->getUser($_GET);
                $view = new View();
                $view->render('homepage.php',new ArticlesModel());
            }
        }
    }
}