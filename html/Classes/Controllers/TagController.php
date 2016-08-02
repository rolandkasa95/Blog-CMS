<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 02.08.2016
 * Time: 13:15
 */

namespace Controllers;


use Models\Tag;
use Views\View;

class TagController
{
    public function init(){
        if(isset($_GET['action'])){
            $action = $_GET['action'];
            switch ($action){
                case 'tag':
                    $name = $_GET['name'];
                    $name = filter_var($name,FILTER_SANITIZE_STRING);
                    $name = trim($name,' ');
                    $tag = new Tag($name);
                    $view = new View();
                    $view->render('tagPage.php',$tag);
            }
        }
    }

}