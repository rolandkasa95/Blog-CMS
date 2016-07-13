<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 08.07.2016
 * Time: 16:48
 */

namespace Models;

Use PDO;

/**
 * Class editarticleModel
 * @package Models
 */
class insertarticleModel
{
    /**
     * @var PDO
     */
    protected $db;
    public $item;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
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
        $tags = 'tags_' . $j;
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

}