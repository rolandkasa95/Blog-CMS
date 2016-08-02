<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 02.08.2016
 * Time: 13:15
 */

namespace Controllers;


use Models\Article;
use Models\Tag;
use Views\View;

class TagController
{
    public function init(){
        $view = new View();
        if(isset($_GET['action'])){
            $action = $_GET['action'];
            switch ($action){
                case 'tag':
                    $name = $_GET['name'];
                    $name = filter_var($name,FILTER_SANITIZE_STRING);
                    $name = trim($name,' ');
                    $tag = new Tag($name);
                    $view->render('tagPage.php',$tag);
                    break;
                case 'deleteTags':
                    $view->render('manageTagsPage.php',new Article());
                    if(isset($_POST['submit']) && 'Update' === $_POST['submit']){
                        $tagToManage = $_SESSION['delete'];
                        $tag = new Tag();
                        $tag->setId($tag->getByName()['tag_id']);
                        $tag->setName($tagToManage);
                        $tag->save();
                    }
                    if(isset($_SESSION['delete']) && 'Delete' === $_POST['submit']){
                        $tagToManage = new Tag();
                        $tagToManage->setName(strtolower($_SESSION['delete']));
                        $tagToManage->setId($tagToManage->getByName()['tag_id']);
                        $tagToManage->deleteById();
                     }
            }
        }
    }

}