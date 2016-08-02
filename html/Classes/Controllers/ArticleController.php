<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 02.08.2016
 * Time: 13:24
 */

namespace Controllers;


use Models\Article;
use Models\Articles;
use Views\View;

class ArticleModel
{
    public function init()
    {
        if(isset($_GET['action'])){
            $action = $_GET['action'];
            switch ($action){
                default:
                    $view = new View();
                    $view->render('homePage.php',new Articles());
            }
        }
    }

}