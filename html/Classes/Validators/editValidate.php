<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 18.07.2016
 * Time: 12:24
 */

namespace Validators;


use Forms\EditArticleForm;
use Models\Model;
use Views\View;

class editValidate
{
    public $title;
    public $body;
    public $form;
    public $view;

    public function __construct()
    {
        $this->title = $_POST['title'];
        $this->body = $_POST['body'];
    }

    public function validate(){
        $this->view = new View();
        if ($this->validTitle($this->title)){
            if ($this->validBody($this->body)){
                $model = new Model();
                $_GET['id'] = $model->getArticleId($this->title);
                $this->view->render('articlePage.php',$model);
            }else{
                $this->form = new EditArticleForm(new Model());
                $_POST['errorBody'] = 1;
                $this->view->render('adminEditPage.php',$this->form);
            }
        }else{
            $this->form = new EditArticleForm(new Model());
            $_POST['errorTitle'] = 1;
            $this->view->render('adminEditPage.php',$this->form);
        }
    }

    public function validTitle($title){
        $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        return $title;
    }

    public function validBody($body){
        $body = filter_var($body,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        return $body;
    }
}