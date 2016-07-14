<?php

namespace Controllers;

use Forms\EditArticleForm;
use Forms\InsertArticleForm;
use Forms\LoginForm;
use Forms\RegisterForm;
use Models\articlepageModel;
use Models\homepageModel;
use Models\Model;
use Models\selectTagsModel;
use Models\tagpageModel;
use Models\userModel;
use Session\Session;
use Views\View;

/**
 * Class AppController
 * @package Controllers
 */
class AppController
{
    public $view;
    public $model;
    public $form;
    public $loginController;
    public $session;

    public function init()
    {
        $view = new View();

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case 'articleShow' :
                    $this->model = new Model();
                    $view->render('articlePage.php', $this->model);
                    break;
                case 'tag':
                    $this->model = new Model();
                    $view->render('tagPage.php', $this->model);
                    break;
                case 'login' :
                    $this->model = new Model();
                    if (session_start()) {

                        session_unset();
                        session_destroy();
                    }
                    $this->form = new LoginForm($this->model);
                    $view->render('loginpage.php', $this->form);
                    break;
                case 'validate' :
                    if (isset($_POST['submit'])) {
                        $this->model = new Model();
                        if ($this->model->getUsername($_POST['username'])) {
                            $this->session = new \Models\Session();
                            $this->session->init();
                            $this->model = new Model();
                            $view->render('homePage.php', $this->model);
                        } else {
                            $view->render("loginpage.php", new LoginForm($this->model));
                            echo "<div class='container'><div class='col-md-1'></div><div class='col-md-8' style=\"text-align: center\"><h4 style='color: red'>Enter a Valid username and password</h4></div></div>";
                        }
                    }
                    break;
                case 'insert':
                    $this->model = new Model();
                    $this->form = new InsertArticleForm($this->model);
                    $view->render('editPage1.php', $this->form);
                    break;
                case 'edit' :
                    $this->model = new Model();
                    $this->form = new EditArticleForm($this->model);
                    $view->render('adminEditPage.php', $this->form);
                    break;
                default:
                    $this->model = new Model();
                    $view->render('homePage.php', $this->model);
                    break;
            }
        }else{
            $this->model = new Model();
            $view->render('homePage.php', $this->model);
        }
    }
}