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

    /**
     * insertValidate constructor.
     */
    public function __construct()
    {
        $this->title = $_POST['title'];
        $this->body = $_POST['body'];
    }

    /**
     * insertValidate function
     */
    public function validate(){
        $this->view = new View();
        if ($this->validTitle($this->title)){
            if ($this->validBody($this->body)){
                $model = new Model();
                $_GET['id'] = $model->getArticleId($this->title);
                $this->view->render('articlePage.php',$model);
            }else{
                $this->form = new InsertArticleForm(new Model());
                $_POST['errorBody'] = 1;
                $this->view->render('editPage1.php',$this->form);
            }
        }else{
            $this->form = new InsertArticleForm(new Model());
            $_POST['errorTitle'] = 1;
            $this->view->render('editPage1.php',$this->form);
        }
    }

    /**
     * ValidTitle
     *
     * @param $title
     * @return bool
     */
    public function validTitle($title){
        $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        $model = new Model();
        $bool = $model->checkInTable(' WHERE title="' . $title . '"');
        if(false === $bool){
            return false;
        }
        if(empty($title)) {
            return false;
        }
        return true;
        }

    /**
     * ValidBody
     *
     * @param $body
     * @return mixed
     */
    public function validBody($body){
        $body = filter_var($body,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
        return !empty($body);
    }
}