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

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function insertArticle(){
        $this->connect(\ObjectFactoryService::getConfig());
        $sql="INSERT INTO articles(user_id,title,author,body,date,isPublished) VALUES (" . $this->getIdFromUsers() . ",'" . $_POST['title'] . "','" . $_SESSION['username'] . "','" . $_POST['body'] . "','" . date('Y-m-d') . "'," . $_POST['submit']?1:0;
        $insert = $this->db->prepare($sql);
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
        for($j=0;$j<3;$j++){
            $name = 'select' + $j;
            $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (" . $this->getArticleId($_POST['title']) . "," . $this->getTagId($_POST[$name]) . ")";
            $insert = $this->db->prepare($sql);
            $insert->execute();
        }
    }

    public function getTagId($tagName){
        $this->connect(\ObjectFactoryService::getConfig());
        $sql = "SELECT id FROM tags WHERE name='" . $tagName . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    public function showArticle(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $id = $_GET['id'];
        $sql='SELECT title,date,body FROM articles WHERE isPublished=1 AND article_id=' .$id ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

}