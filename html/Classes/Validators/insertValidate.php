<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 14.07.2016
 * Time: 16:57
 */

namespace Validators;


use Forms\InsertArticleForm;
use Models\Model;
use Views\View;

class insertValidate
{
    public $title;
    public $body;
    public $form;
    public $view;
    
    public function __construct()
    {
        $this->title = $_POST['title'];
        $this->body = $_POST['body'];
        var_dump($this->body);
        var_dump($this->title);
    }

    public function validate(){
        $this->view = new View();
        if ($this->validTitle($this->title)){
            if ($this->validBody($this->body)){
                $model = new Model();
                $_GET['id'] = $model->getArticleId($this->title);
                var_dump($_GET);
                die;
                $this->view->render('articlePage.php',$model);
            }else{
                $this->form = new InsertArticleForm(new Model());
                $this->form->getErrorMessageBody();
                $this->view->render('editPage1.php',$this->form);
            }
        }else{
            $this->form = new InsertArticleForm(new Model());
            $this->form->getErrorMessageTitle();
            $this->view->render('editPage1.php',$this->form);
        }
    }

    public function validTitle($title){
        $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        var_dump($title);
        $model = new Model();
        $bool = $model->checkInTable(' WHERE title="' . $title . '"');
        var_dump($bool);
        return $bool;
    }

    public function validBody($body){
        $body = filter_var($body,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        var_dump($body);
        return $body;
    }
}