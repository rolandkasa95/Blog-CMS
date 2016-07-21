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
                    $class = new LoginController();
                    $class->init();
                    break;
                case 'validate' :
                    $class = new ValidateLoginController();
                    $class->init();
                    break;
                case 'tags':
                    $class = new ManageTagsController();
                    $class->init();
                    break;
                case 'adminPanel':
                    $class = new AdminPanelController();
                    $class->init();
                    break;
                /**
                 * This case initiates the insert form
                 */
                case 'insert':
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
                 * in descendant order
                 */
                default:
                    $view->render('Page404.php',new Model());
            }
        }else{
            $this->model = new Model();
            $view->render('homePage.php', $this->model);
        }
    }
}