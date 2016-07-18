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

    /**
     * editValidate constructor.
     */
    public function __construct()
    {
        $this->title = $_POST['title'];
        $this->body = $_POST['body'];
    }

    /**
     * Validate function for the Edit
     */
    public function validate(){
        $this->view = new View();
        if ($this->validTitle($this->title)){
            if ($this->validBody($this->body)){
                $model = new Model();
                $_GET['id'] = $model->getArticleId($this->title);
                $this->view->render('articlePage.php',$model);
            }else{
                $_POST['errorBody'] = 1;
                $this->view->render('adminEditPage.php',new EditArticleForm(new Model()));
            }
        }else{
            $_POST['errorTitle'] = 1;
            $this->view->render('adminEditPage.php',new EditArticleForm(new Model()));
        }
    }

    public function validTitle($title){
        $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        return !empty($title);
    }

    public function validBody($body){
        $body = filter_var($body,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        return !empty($body);
    }
}