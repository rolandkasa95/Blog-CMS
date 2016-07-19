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
    /**
     * @var object
     */
    public $view;
    /**
     * @var object
     */
    public $model;
    /**
     * @var object
     */
    public $form;
    /**
     * @var object
     */
    public $loginController;
    /**
     * @var object
     */
    public $session;
    /**
     * @var session
     */

    /**
     * Init function.
     *
     * This is the controller for the whole application
     */
    public function init()
    {
        $view = new View();

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                /**
                 * This case lists the article
                 */
                case 'articleShow' :
                    $this->model = new Model();
                    $view->render('articlePage.php', $this->model);
                    break;
                /**
                 * This case list the articles which contain a specific tag
                 */
                case 'tag':
                    $this->model = new Model();
                    $view->render('tagPage.php', $this->model);
                    break;
                /**
                 * This case is the login
                 */
                case 'login' :
                    $this->model = new Model();
                    if (session_start()) {

                        session_unset();
                        session_destroy();
                    }
                    $this->form = new LoginForm($this->model);
                    $view->render('loginpage.php', $this->form);
                    break;
                /**
                 * This case validates the login, and enters the session
                 */
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
                /**
                 * This lead to the adminPanel
                 */
                case 'adminPanel':
                    $view->render('adminPanel.php',new Model());
                    break;
                /**
                 * This case initiates the insert form
                 */
                case 'insert':
                    $this->model = new Model();
                    $this->form = new InsertArticleForm($this->model);
                    $view->render('editPage1.php', $this->form);
                    break;
                /**
                 * This case initiates the edit form
                 */
                case 'edit' :
                    $this->model = new Model();
                    $this->form = new EditArticleForm($this->model);
                    $view->render('adminEditPage.php', $this->form);
                    break;
                /**
                 * The default case is the home page, wich is the list of articles
                 * descendently
                 */
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