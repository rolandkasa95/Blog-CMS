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
        $bool = $_POST['submit']?1:0;
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $body = filter_input(INPUT_POST,'body',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $sql="INSERT INTO articles(user_id,title,author,body,date,isPublished) VALUES (:user_id,:title,:author,:body,:date,:isPublished)";
        $insert = $this->db->prepare($sql);
        $insert->bindParam(':user_id',$this->getIdFromUsers(),PDO::PARAM_INT);
        $insert->bindParam(':title',trim(str_replace("'","\'",str_replace('"','\"',$title)),' '),PDO::PARAM_STR,100);
        $insert->bindParam(':author',$_SESSION['username'],PDO::PARAM_STR,100);
        $insert->bindParam(':body',trim(str_replace("'","\'",str_replace('"','\"',$body)),' '),PDO::PARAM_STR,100);
        $insert->bindParam(':date',new \DateTime(time()));
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
        $j = 0;
        $tags = 'tags_' . $j;
        foreach($_POST as $item) {
            if (isset($_POST[$tags])) {
                $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':article_id',$this->getArticleId($_POST['title']),PDO::PARAM_INT);
                $insert->bindParam(':tag_id',$this->getTagId(trim($_POST[$tags]),' '),PDO::PARAM_INT);
                $insert->execute();
            }
            $j++;
            $tags = 'tags_' . $j;
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