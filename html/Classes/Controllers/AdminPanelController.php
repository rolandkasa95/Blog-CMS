<?php

namespace Controllers;


use Models\Model;
use Views\View;

class AdminPanelController extends AppController
{
    public function init(){
        $view = new View();
        $view->render('adminPanel.php',new Model());
    }
}