<?php

namespace Controllers;


use Forms\LoginForm;
use Models\Model;
use Models\Session;
use Views\View;

class ValidateLoginController extends AppController
{
    public function init()
    {
        $view = new View();
        if (isset($_POST['submit'])) {
            $this->model = new Model();
            if ($this->model->getUsername($_POST['username'])) {
                $this->session = new Session();
                $this->session->init();
                $this->model = new Model();
                $view->render('homePage.php', $this->model);
            } else {
                $view->render("loginpage.php", new LoginForm($this->model));
                echo "<div class='container'><div class='col-md-1'></div><div class='col-md-8' style=\"text-align: center\"><h4 style='color: red'>Enter a Valid username and password</h4></div></div>";
            }
        }
    }
}