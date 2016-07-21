<?php

namespace Controllers;


use Forms\manageTagsForm;
use Models\Model;
use Views\View;

class ManageTagsController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new manageTagsForm(new Model());
        $view->render('manageTagsPage.php',$this->model);
    }

}