<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 21.07.2016
 * Time: 17:08
 */

namespace Controllers;


use Models\Model;
use Views\View;

class ArticleShowController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $view->render('articlePage.php', $this->model);
    }
}