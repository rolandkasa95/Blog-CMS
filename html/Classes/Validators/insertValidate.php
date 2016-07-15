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
    }

    public function validate(){
        $this->view = new View();
        if ($this->validTitle($this->title)){
            if ($this->validBody($this->body)){
                $model = new Model();
                $_GET['id'] = $model->getArticleId($this->title);
                header('Location: index.php?action=articleShow&id=' . $_GET['id']);
            }else{
                $this->form = new InsertArticleForm(new Model());
                $_POST['errorBody'] = 1;
                header('Location: index.php?action=insert');
            }
        }else{
            $this->form = new InsertArticleForm(new Model());
            $_POST['errorTitle'] = 1;
            header('Location: index.php?action=insert');
        }
    }

    public function validTitle($title){
        $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        $model = new Model();
        $bool = $model->checkInTable(' WHERE title="' . $title . '"');
        return $bool;
    }

    public function validBody($body){
        $body = filter_var($body,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        var_dump($body);
        return $body;
    }
}