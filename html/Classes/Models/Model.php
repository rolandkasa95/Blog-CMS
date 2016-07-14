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

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }
    public function tagNameDisplay(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $id = $_GET['id'];
        $sql='SELECT name FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id WHERE articles.article_id=' .$id . ' AND articles.isPublished=1';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
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

    public function editArticle(){
        try {
            $this->connect(\ObjectFactoryService::getConfig());
            $date = new \DateTime();
            $bool = $_POST['submit'] ? 1 : 0;
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
            $sql = "UPDATE articles SET user_id=:user_id, title=:title, author=:author, body=:body, date=:date, isPublished=:isPublished WHERE article_id=:id";
            $insert = $this->db->prepare($sql);
            $insert->bindParam(':user_id', $this->getIdFromUsers(), PDO::PARAM_INT);
            $insert->bindParam(':title', trim($title, ' '), PDO::PARAM_STR, 100);
            $insert->bindParam(':author', $_SESSION['username'], PDO::PARAM_STR, 100);
            $insert->bindParam(':body', trim($body, ' '), PDO::PARAM_STR, 100);
            $insert->bindParam(':date', $date->format('Y-m-d H:i:sP'));
            $insert->bindParam('isPublished', $bool, PDO::PARAM_BOOL);
            $insert->bindParam(':id', $id, PDO::PARAM_INT);
            $insert->execute();
            return;
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

    public function editNewTags(){
        $this->connect(\ObjectFactoryService::getConfig());
        try{
            $newTags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
            $newTags = explode(',',$newTags);
            foreach ($newTags as $key => $value) {
                $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                $statement = $this->db->prepare($sql);
                $statement->bindParam(':article_id',$this->getArticleId($_POST['title']),PDO::PARAM_INT);
                $statement->bindParam(':tag_id',$this->getTagId(trim($value,' ')),PDO::PARAM_INT);
                $statement->execute();
            }
        }catch (\PDOException $e){
            echo "Transaction failed: " . $e->getMessage();
        }
    }

    public function getArticles($offset){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql = 'SELECT title,date FROM articles WHERE isPublished=1 ORDER BY date DESC LIMIT 5 OFFSET ' . $offset;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
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

    public function insertArticle(){
        $this->connect(\ObjectFactoryService::getConfig());
        $date = new \DateTime();
        $bool = $_POST['submit']?1:0;
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $body = filter_input(INPUT_POST,'body',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $sql="INSERT INTO articles(user_id,title,author,body,date,isPublished) VALUES (:user_id,:title,:author,:body,:date,:isPublished)";
        $insert = $this->db->prepare($sql);
        $insert->bindParam(':user_id',$this->getIdFromUsers(),PDO::PARAM_INT);
        $insert->bindParam(':title',trim($title,' '),PDO::PARAM_STR,100);
        $insert->bindParam(':author',$_SESSION['username'],PDO::PARAM_STR,100);
        $insert->bindParam(':body',trim($body,' '),PDO::PARAM_STR,100);
        $insert->bindParam(':date',$date->format('Y-m-d H:i:sP'));
        $insert->bindParam('isPublished',$bool,PDO::PARAM_BOOL);
        $insert->execute();
    }

    public function editArticlesTags(){
        $this->connect(\ObjectFactoryService::getConfig());
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $sql = "DELETE FROM articles_tags WHERE article_id=$id";
        $insert = $this->db->prepare($sql);
        $insert->execute();
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $title = trim($title,' ');
        $j = 0;
        for($j=0;$j<=$this->count();$j++){
            $tags = 'tags_' . $j;
            if (isset($_POST[$tags])) {
                $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
                $sql = "INSERT INTO articles_tags (article_id,tag_id) VALUES (:article_id,:tag_id)";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':article_id', $id, PDO::PARAM_INT);
                $insert->bindParam(':tag_id',$this->getTagId(trim($_POST[$tags]),' '),PDO::PARAM_INT);
                $insert->execute();
            }
        }
        return;
    }

    public function insertArticlesTags(){
        $this->connect(\ObjectFactoryService::getConfig());
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $title = trim($title,' ');
        $j = 0;
        for($j=0;$j<=$this->count();$j++){
            $tags = 'tags_' . $j;
            echo $j;
            if (isset($_POST[$tags])) {
                echo $j;
                $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
                $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':article_id',$this->getArticleId($title),PDO::PARAM_INT);
                $insert->bindParam(':tag_id',$this->getTagId(trim($_POST[$tags]),' '),PDO::PARAM_INT);
                $insert->execute();
            }
        }
    }

    public function insertTag(){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $button = $_POST['submit'] ?1:0;
            $tags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
            if(strpos($tags,',')) {
                $tags = explode(',', $_POST['tag']);
                foreach ($tags as $key => $value) {
                    $value = trim($value,' ');
                    if($this->inTable($value)) {
                        $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
                        $statement = $this->db->prepare($sql);
                        $statement->bindParam(':name', $value,  PDO::PARAM_STR, 100);
                        $statement->bindParam(':isVisible', $button, PDO::PARAM_BOOL);
                        $statement->execute();
                    }
                }
            }else{
                $value = trim($_POST['tag'],' ');
                if($this->inTable($tags)) {
                    $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':name', $value, PDO::PARAM_STR, 100);
                    $statement->bindParam(':isVisible', $button, PDO::PARAM_BOOL);
                    $statement->execute();
                }
            }
            return;
        }catch (\PDOException $e){
            echo "Transaction Failed: " . $e->getMessage();
        }
    }
    public function inTable($tags){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $sql = "SELECT tag_id FROM tags WHERE name=:name";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':name',$tags,PDO::PARAM_STR,100);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_COLUMN);
            if(empty($result)){
                return true;
            }else{
                return false;
            }
        }catch (\PDOException $e){
            echo "Transaction failed" . $e->getMessage();
        }
    }

    public function insertNewTags(){
        $this->connect(\ObjectFactoryService::getConfig());
        try{
            $newTags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
            $newTags = explode(',',$newTags);
            foreach ($newTags as $key => $value) {
                $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                $statement = $this->db->prepare($sql);
                $statement->bindParam(':article_id',$this->getArticleId($_POST['title']),PDO::PARAM_INT);
                $statement->bindParam(':tag_id',$this->getTagId(trim($value,' ')),PDO::PARAM_INT);
                $statement->execute();
            }

        }catch (\PDOException $e){
            echo "Transaction failed: " . $e->getMessage();
        }
    }

    public function selectTags1(){
        $config = \ObjectFactoryService::getConfig();
        try{
            $this->connect($config);
            $sql = 'SELECT name FROM tags';
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_COLUMN);
            return $result;
        }catch(\PDOException $e){
            echo "Failed selection: " . $e->getMessage();
        }
    }

    public function getArticlesByTagName(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $name = filter_input(INPUT_GET,'name',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $sql = 'SELECT title,date FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id  WHERE tags.name="' . $_GET['name'] . '" AND articles.isPublished=1 AND tags.isVisible=1 ORDER BY date DESC';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUsername($param){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $sql = "SELECT * FROM users WHERE  username='" . $param ."'";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($result && password_verify($_POST['password'], $result['password'])){
                return true;
            }else{
                return false;
            }
        }catch (\PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
}