<?php

namespace Controllers;


use Forms\InsertArticleForm;
use Models\Model;
use Views\View;

class InsertController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $this->form = new InsertArticleForm($this->model);
        $view->render('editPage1.php', $this->form);
    }
}