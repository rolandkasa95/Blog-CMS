<?php

namespace Controllers;


use Forms\LoginForm;
use Models\Articles;
use Models\User;
use Views\View;

class UserController
{
    public $view;
    
    public function init()
    {
        $view = new View();
        if (isset($_GET['action'])) {
            if (isset($_SESSION['username'])) {
                if(PHP_SESSION_NONE === session_status() || PHP_SESSION_ACTIVE === session_status()){
                    session_start();
                    session_unset();
                    session_destroy();
                    $view->render('homePage.php', new Articles());
                }else {
                    $view->render('loginpage.php', new LoginForm(new User()));
                }
            }else{
                if(PHP_SESSION_NONE === session_status() || PHP_SESSION_ACTIVE === session_status()){
                    session_start();
                    session_unset();
                    session_destroy();
                    $view->render('loginpage.php', new LoginForm(new User()));
                }else {
                    $view->render('loginpage.php', new LoginForm(new User()));
                }
            }
        }

        if (isset($_GET['action'])){
            if('validate' === $_GET['action']){
                if(isset($_POST['submit'])) {
                    $class = new User();
                    $class->setUsername($_POST['username']);
                    $username = $class->getUser();
                    if ($username) {
                        session_start();
                        $_SESSION['username'] = $username['username'];
                        header('Location: index.php');
                    };
                    $view->render('loginpage.php',new LoginForm(new User()));
                    echo '<div id="login_div"> Please keep in mind: if you add new tags to the article, separate them with a comma! Thank you! </div>';
                }
            }
        }
    }
}