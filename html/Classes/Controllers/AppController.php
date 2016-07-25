<?php

namespace Controllers;

use Forms\EditArticleForm;
use Forms\InsertArticleForm;
use Forms\LoginForm;
use Forms\manageTagsForm;
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
                case 'articleShow' :
                    $class = new ArticleShowController();
                    $class->init();
                    break;
                case 'tag':
                    $class = new TagShowController();
                    $class->init();
                    break;
                case 'login' :
                    $class = new LoginController();
                    $class->init();
                    break;
                case 'validate' :
                    $class = new ValidateLoginController();
                    $class->init();
                    break;
                case 'adminPanel':
                    $class = new AdminPanelController();
                    $class->init();
                    break;
                case 'insert':
                    $class = new InsertController();
                    $class->init();
                    break;
                case 'edit' :
                    $class = new EditController();
                    $class->init();
                    break;
                case 'deleteTags':
                    $class = new ManageTagsController();
                    $class->init();
                    break;
                default:
                    $view->render('Page404.php',new Model());
            }
        }else{
            $class = new HomeController();
            $class->init();
        }
    }
}