<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 21.07.2016
 * Time: 17:06
 */

namespace Controllers;


use Models\Model;
use Views\View;

class TagShowController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $view->render('tagPage.php', $this->model);
    }
}