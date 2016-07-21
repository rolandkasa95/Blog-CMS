<?php

namespace Controllers;


use Forms\LoginForm;
use Models\Model;
use Views\View;

class LoginController extends AppController
{
    public function init(){
        $view = new View();
        session_start();
        if(!isset($_SESSION['username'])) {
            $this->model = new Model();
            if (session_start()) {

                session_unset();
                session_destroy();
            }
            $this->form = new LoginForm($this->model);
            $view->render('loginpage.php', $this->form);
        }else{
            session_unset();
            session_destroy();
            $view->render('homePage.php',new Model());
        }
    }
}