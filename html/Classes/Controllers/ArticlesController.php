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
                    $view->render('editPage1.php',new InsertArticleForm(new Article));
            }
            }else{
            $view->render('homePage.php',new Articles());
        }
    }

}