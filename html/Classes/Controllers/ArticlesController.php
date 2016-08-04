<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 02.08.2016
 * Time: 13:24
 */

namespace Controllers;


use Forms\EditArticleForm;
use Forms\InsertArticleForm;
use Models\Article;
use Models\Articles;
use Models\Tag;
use Validators\ArticleValidate;
use Validators\ImageValidator;
use Views\View;

class ArticlesController
{
    public function init()
    {
        $view = new View();
        if(isset($_GET['action'])){
            $action = $_GET['action'];
            switch ($action){
                case 'articleShow' :
                    $id = $_GET['id'];
                    $article = new Article($id);
                    $view->render('articlePage.php',$article);
                    break;
                case 'adminPanel':
                    $view->render('adminPanel.php',new Article());
                    break;
                case 'insert':
                    if(isset($_POST['submit'])) {
                        $this->insert();
                    }
                    $view->render('editPage1.php',new InsertArticleForm(new Article));
                    break;
                case 'edit':
                    if(isset($_POST['submit'])) {
                        ArticleValidate::valid();
                        ImageValidator::valid();
                        $article = new Article();
                        $article->setId($_GET['id']);
                        $article->setTitle($_POST['title']);
                        $article->setBody($_POST['body']);
                        $article->setTag($_POST['tag']);
                        $article->setUrlImage('Layouts/uploads/' . $_FILES['fileToUpload']['name']);
                        $tag = new Tag($_POST['tag']);
                        $tag->save();
                        $article->save(1);
                        $article->saveArticleTags();
                        header('Location: index.php');
                    }
                    $view->render('adminEditPage.php',new EditArticleForm(new Article));
                    break;
            }
            }else{
            $view->render('homePage.php',new Articles());
        }
    }

    public function insert()
    {
        ArticleValidate::valid();
        ImageValidator::valid();
        $article = new Article();
        $article->setTitle($_POST['title']);
        $article->setBody($_POST['body']);
        $article->setTag($_POST['tag']);
        $article->setUrlImage('Layouts/uploads/' . $_FILES['fileToUpload']['name']);
        $tag = new Tag($_POST['tag']);
        $tag->save();
        $article->save(1);
        $article->saveArticleTags();
        header('Location: index.php');
    }

}