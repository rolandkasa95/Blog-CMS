<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 21.07.2016
 * Time: 17:01
 */

namespace Controllers;


use Forms\EditArticleForm;
use Models\Model;
use Views\View;

class EditController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $this->form = new EditArticleForm($this->model);
        $view->render('adminEditPage.php', $this->form);
    }
}