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
use Validators\editValidate;
use Views\View;

class EditController extends AppController
{
    public function init(){
        $view = new View();
        $this->model = new Model();
        $this->form = new EditArticleForm($this->model);
        ob_start();
        $view->render('adminEditPage.php', $this->form);
        if(isset($_POST['errorBody'])  && isset($_POST['errorTitle'])){
            ob_end_clean();
        }
        $this->edit();
    }

    /**
     * Object process
     *
     * validation and integration in the database
     */
    public function edit(){
        if(isset($_POST['submit']) && $_POST['submit'] === 'Publish'){
            if (!isset($_POST['errorBody'])  && !isset($_POST['errorTitle'])) {
                $valid = new editValidate();
                $result = $valid->validate();
            }
            if(!empty($_POST['tag']) && '' !== $_POST['tag'] && !isset($_POST['errorBody'])  && !isset($_POST['errorTitle'])) {
                $this->model = new \Models\Model();
                $this->model->insertTag();
            }
            if(!empty($_POST['body']) && !empty($_POST['title']) && !isset($_POST['errorBody'])  && !isset($_POST['errorTitle'])) {
                $this->model = new \Models\Model();
                $this->model->editArticle();
                $this->model->editArticlesTags();
                $this->model->editNewTags();
                $title = $_POST['title'];
                $title = filter_var($title,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_LOW);
                $id = $this->model->getArticleId($title);
                header('Location: index.php?action=articleShow&id='.$id);
            }
        }

    }
}