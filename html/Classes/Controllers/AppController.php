<?php

namespace Controllers;

use Forms\InsertArticleForm;
use Forms\LoginForm;
use Forms\RegisterForm;
use Models\articlepageModel;
use Models\homepageModel;
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

        if (!isset($_GET['action']) || empty($_GET['action'])) {
            $this->model = new homepageModel();
            $view->render('homePage.php', $this->model);
        }
        if (isset($_GET['action']) && 'articleShow' === $_GET['action']) {
            $this->model = new articlepageModel();
            $view->render('articlePage.php', $this->model);
        }
        if (isset($_GET['action']) && 'tag' === $_GET['action']) {
            $this->model = new tagpageModel();
            $view->render('tagPage.php', $this->model);
        }
        if (isset($_GET['action']) && 'login' === $_GET['action']) {
            $this->model = new userModel();
            if (session_start()){
                
                session_unset();
                session_destroy();
            }
            $this->form = new LoginForm($this->model);
            $view->render('loginpage.php', $this->form);
        }
        if (isset($_GET['action']) && 'validate' === $_GET['action'] && isset($_POST['submit']) ) {
            $this->model = new userModel();
            if($this->model->getUsername($_POST['username'])){
                    $this->session = new \Models\Session();
                    $this->session->init();
                    $this->model = new homepageModel();
                    $view->render('homePage.php',$this->model);
                }else{
                $view->render("loginpage.php",new LoginForm($this->model));
                echo "<div class='container'><div class='col-md-1'></div><div class='col-md-8' style=\"text-align: center\"><h4 style='color: red'>Enter a Valid username and password</h4></div></div>";
            }
        }
        if(isset($_GET['action']) && 'edit' === $_GET['action']){
//            $this->model= new selectTagsModel();
//            $view->render('editPage.php',$this->model);
            $this->model = new selectTagsModel();
            $this->form = new InsertArticleForm($this->model);
            $view->render('editPage1.php', $this->form);
        }
        }
}