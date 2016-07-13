<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 13.07.2016
 * Time: 16:07
 */

namespace Models;

use PDO;


class editarticleModel
{
    /**
     * @var \PDO
     */
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function showArticle(){
       try {
           $config = \ObjectFactoryService::getConfig();
           $this->connect($config);
           $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $sql = 'SELECT title,date,body FROM articles WHERE article_id=:id';
           $statement = $this->db->prepare($sql);
           $statement->bindParam(':id', $id, PDO::PARAM_INT);
           $statement->execute();
           $result = $statement->fetch(\PDO::FETCH_ASSOC);
           return $result;
       }catch (\PDOException $e){
           echo $e->getMessage();
       }
    }

    public function insertArticle(){
        try {
            $this->connect(\ObjectFactoryService::getConfig());
            $date = new \DateTime();
            $bool = $_POST['submit'] ? 1 : 0;
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $sql = "UPDATE articles SET user_id=:user_id, title=:title, author=:author, body=:body, date=:date, isPublished=:isPublished WHERE article_id=:id";
            $insert = $this->db->prepare($sql);
            var_dump($insert);
            $insert->bindParam(':user_id', $this->getIdFromUsers(), PDO::PARAM_INT);
            $insert->bindParam(':title', trim($title, ' '), PDO::PARAM_STR, 100);
            $insert->bindParam(':author', $_SESSION['username'], PDO::PARAM_STR, 100);
            $insert->bindParam(':body', trim($body, ' '), PDO::PARAM_STR, 100);
            $insert->bindParam(':date', $date->format('Y-m-d H:i:sP'));
            $insert->bindParam('isPublished', $bool, PDO::PARAM_BOOL);
            $insert->bindParam(':id', $id, PDO::PARAM_INT);
            var_dump($insert);
            $insert->execute();
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getIdFromUsers(){
        $this->connect(\ObjectFactoryService::getConfig());
        $sql = "SELECT user_id FROM users WHERE username='" . $_SESSION['username'] ."'";
        $select = $this->db->prepare($sql);
        $select->execute();
        $result= $select->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    public function insertArticlesTags(){
        $this->connect(\ObjectFactoryService::getConfig());
        $model = new tagpageModel();
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $title = trim($title,' ');
        $j = 0;
        for($j=0;$j<=$this->count();$j++){
            $tags = 'tags_' . $j;
            echo $j;
            if (isset($_POST[$tags])) {
                echo $j;
                $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
                $sql = "UPDATE articles_tags SET tag_id=:tag_id WHERE article_id=:article_id";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':article_id', $id, PDO::PARAM_INT);
                $insert->bindParam(':tag_id',$this->getTagId(trim($_POST[$tags]),' '),PDO::PARAM_INT);
                $insert->execute();
            }
        }
    }

    public function count(){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $sql = "SELECT tag_id FROM tags";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $i=0;
            foreach ($result as $item){
                $i++;
            }
            return $i;
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getTagId($tagName){
        $this->connect(\ObjectFactoryService::getConfig());
        $sql = "SELECT tag_id FROM tags WHERE name=\"" . $tagName . "\"";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    public function getArticleId($articleTitle){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql="SELECT article_id FROM articles WHERE title='" .$articleTitle . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    public function insertNewTags(){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $newTags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
            $newTags = explode(',',$newTags);
            foreach ($newTags as $key => $value) {
                $sql = "UPDATE articles_tags SET tag_id=:tag_id WHERE article_id=:article_id";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':article_id', $id, PDO::PARAM_INT);
                $insert->bindParam(':tag_id',$this->getTagId(trim($value),' '),PDO::PARAM_INT);
                $insert->execute();
            }

        }catch (\PDOException $e){
            echo "Transaction failed: " . $e->getMessage();
        }
    }


}