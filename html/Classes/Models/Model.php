<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 14.07.2016
 * Time: 16:00
 */

namespace Models;

use PDO;
USE PDOException;

class Model
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * Connection to database
     *
     * @param $config array
     */
    public function connect(){
        try {
            $config = \ObjectFactoryService::getConfig();
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }


    /**
     *
     * Controller: option: edit
     *
     */
    public function editArticle(){
        $article = new Article();        
        $imagePath = "/Layouts/uploads/";
        $imagePath .= $_FILES['fileToUpload']['name'];
        $article->setUrlImage($imagePath);
        $bool = $_POST['submit'] ? 1 : 0;
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $article->setId($id);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
        $article->setTitle($title);
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS  , FILTER_FLAG_STRIP_LOW );
        $article->setBody($body);
        $article->save($bool);
    }


    
    
    /**
     *
     * Controller -> Article: option Insert
     *
     */
    public function insertArticle(){
        $article = new Article();
        $imagePath = "/Layouts/uploads/";
        $imagePath .= $_FILES['fileToUpload']['name'];
        $article->setUrlImage($imagePath);
        $bool = $_POST['submit']?1:0;
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $article->setTitle($title);
        $body = filter_input(INPUT_POST,'body',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $article->setBody($body);
        $article->save($bool);
    }
    
    
}