<?php

namespace Controllers;


use Models\User;
use Views\View;

class UserController
{
    public $view;
    
    public function init()
    {
        if (isset($_GET['action'])){
            if('login' === $_GET['action']){
                $class = new User();
                $class->setUsername($_POST['username']);
                if($class->getUser()){
                    $_SESSION['username'] = $class->getUser()['username'];
                    session_start();
                };
                $view = new View();
                $view->render('homepage.php',new ArticlesModel());
            }
        }
    }
}