<?php

namespace Controllers;


use Models\Article;
use Models\Articles;
use Models\User;
use Views\View;

class UserController
{
    public $view;
    
    public function init()
    {
        if (isset($_GET['action'])){
            if('validate' === $_GET['action']){
                if(isset($_POST['submit'])) {
                    $class = new User();
                    $class->setUsername($_POST['username']);
                    $username = $class->getUser();
                    if (!empty($username)) {
                        session_start();
                        $_SESSION['username'] = $username['username'];
                    };
                    header('Location: index.php');
                }
            }
        }
    }
}