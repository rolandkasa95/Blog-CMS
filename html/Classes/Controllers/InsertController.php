<?php

namespace Controllers;


use Forms\InsertArticleForm;
use Models\Model;
use Validators\insertValidate;
use Views\View;

class InsertController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $this->form = new InsertArticleForm($this->model);
        ob_start();
        $view->render('editPage1.php', $this->form);
        if(isset($_POST['errorBody'])  && isset($_POST['errorTitle'])){
            ob_end_clean();
        }
        $this->insertData();
    }

    /**
     * The form
     *
     * Validation and generation
     */
    public function insertData(){
        if(isset($_POST['submit']) && $_POST['submit'] === 'Publish'){
            if (!isset($_POST['errorBody'])  && !isset($_POST['errorTitle']) && !isset($_POST['errorFile'])) {
                $valid = new insertValidate();
                $valid->validate();
            }
                if (!empty($_POST['tag']) && '' !== $_POST['tag'] && !isset($_POST['errorBody']) && !isset($_POST['errorTitle']) && !isset($_POST['errorFile'])) {
                    $this->model = new \Models\Model();
                    $this->model->insertTag();
                }
                if (!empty($_POST['body']) && !empty($_POST['title']) && !isset($_POST['errorBody']) && !isset($_POST['errorTitle']) && !isset($_POST['errorFile'])) {
                    $this->model = new \Models\Model();
                    $this->model->insertArticle();
                    $this->model->insertArticlesTags();
                    $this->model->insertNewTags();
                    $title = $_POST['title'];
                    $title = filter_var($title, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
                    $id = $this->model->getArticleId($title);
                    header('Location: index.php?action=articleShow&id=' . $id);
            }
        }
    }
}