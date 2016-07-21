<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 21.07.2016
 * Time: 17:04
 */

namespace Controllers;


use Models\Model;
use Views\View;

class HomeController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $view->render('homePage.php', $this->model);
    }
}