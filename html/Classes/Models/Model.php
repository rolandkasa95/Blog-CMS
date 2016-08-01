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
     * Displays the tagname by the id of the article
     *
     * @return array
     */
    public function tagNameDisplay(){
        $this->connect();
        $id = $_GET['id'];
        $sql='SELECT name FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id WHERE articles.article_id=' .$id . ' AND articles.isPublished=1';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Returns the article title date and body by it's
     * id
     *
     * @return array
     */
    public function showArticle(){
        try {
            $this->connect();
            $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
            $sql = 'SELECT title,date,body,imagePath FROM articles WHERE article_id=:id';
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result;
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     *
     * Edit The article by the parameters given
     * by the post and get
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
     * Returns the id of the user currently logged in
     *
     * @return mixed
     */
    public function getIdFromUsers(){
        $this->connect();
        $sql = "SELECT user_id FROM users WHERE username='" . $_SESSION['username'] ."'";
        $select = $this->db->prepare($sql);
        $select->execute();
        $result= $select->fetch(PDO::FETCH_COLUMN);
        return $result;
    }

    /**
     * Retruns the number of the tags inside of the
     * table
     *
     * @return int
     */
    public function count(){
        try{
            $this->connect();
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
    

    /**
     *
     * Inserts the new tags to the article given by the user
     *
     */
    public function editNewTags(){
        $this->connect();
        try{
            $newTags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
            $newTags = explode(',',$newTags);
            $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            foreach ($newTags as $key => $value) {
                if($this->articlesTagsInTable($this->getArticleId($title),$this->getTagId(trim($value,' ')))) {
                    $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':article_id', $this->getArticleId($title), PDO::PARAM_INT);
                    $statement->bindParam(':tag_id', $this->getTagId(trim($value, ' ')), PDO::PARAM_INT);
                    $statement->execute();
                }
            }
        }catch (\PDOException $e){
            echo "Transaction failed: " . $e->getMessage();
        }
    }

    /**
     * Checks if the article is connected with the tag
     *
     * @param $article_id int
     * @param $tag_id int
     * @return bool
     */
    public function articlesTagsInTable($article_id,$tag_id){
        try{
            $this->connect();
            $sql = "SELECT * FROM articles_tags WHERE article_id=:article_id AND tag_id=:tag_id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':article_id',$article_id,PDO::PARAM_INT);
            $statement->bindParam('tag_id',$tag_id,PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(false === $result){
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * Show exactly  articles which is affected by the offset
     *
     * @param $offset int
     * @return array
     */
    public function getArticles($offset){
        $this->connect();
        $sql = 'SELECT title,date,article_id FROM articles WHERE isPublished=1 ORDER BY date DESC LIMIT 5 OFFSET ' . $offset;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    /**
     *
     * Insert a new article to the table
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

    /**
     *
     * Insert The tags which were selected to the articles_tags
     * table.
     *
     */
    public function editArticlesTags(){
        $this->connect();
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

    /**
     *
     * Insert The tags which were selected to the articles_tags
     * table.
     *
     */
    public function insertArticlesTags(){
        $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $title = trim($title,' ');
        $tags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
        $tags = explode(',', $tags);
        foreach ($tags as $value) {
            $value = trim($value, ' ');
            $tag = new Tag($value);
            $real_tags[] = $tag;
            $tag->save($value);
            }
        }

    /**
     * Inserts a new tag
     */
    public function insertTag(){
        try{
            $this->connect();
            $button = $_POST['submit'] ?1:0;
            $tags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
                $tags = explode(',', $tags);
                foreach ($tags as $value) {
                    $value = trim($value,' ');
                    $tag = new Tag();
                    $tag->setName($value);
                    $tag->save($value,$button);
                    }
        }catch (\PDOException $e){
            echo "Transaction Failed: " . $e->getMessage();
        }
    }

    /**
     * Checks if the tag is in the table
     *
     * @param $tags string
     * @return bool
     */
    public function inTable($tags){
        try{
            $this->connect();
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

    /**
     *
     * Connects the articles to the tags
     *
     */
    public function insertNewTags(){
        $this->connect();
        try{
            $newTags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);
            $newTags = explode(',',$newTags);
            $title = filter_input(INPUT_POST,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            foreach ($newTags as $key => $value) {
                if($this->articlesTagsInTable($this->getArticleId($title),$this->getTagId(trim($value,' ')))) {
                    $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':article_id', $this->getArticleId($_POST['title']), PDO::PARAM_INT);
                    $statement->bindParam(':tag_id', $this->getTagId(trim($value, ' ')), PDO::PARAM_INT);
                    $statement->execute();
                }
            }

        }catch (\PDOException $e){
            echo "Transaction failed: " . $e->getMessage();
        }
    }

    /**
     * Selects the tag name
     *
     * @return array
     */
    public function selectTags1(){
        try{
            $this->connect();
            $sql = 'SELECT name FROM tags';
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_COLUMN);
            return $result;
        }catch(\PDOException $e){
            echo "Failed selection: " . $e->getMessage();
        }
    }

    public function selectArticleTagNames(){
        try{
            $this->connect();
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $sql = 'SELECT tags.name FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id  WHERE articles_tags.article_id=:article_id';
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':article_id',$id,PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_COLUMN);
            return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * Select the articles by tag names
     *
     * @return array
     */

    /**
     * Get's the username of the user
     *
     * @param $param
     * @return bool
     */
    
    
    /**
     * Checks if the article is in the table or not
     *
     * @param $param
     * @return bool
     */
    public function checkInTable($param){
        try{
            $this->connect();
            $sql = "SELECT article_id FROM articles" . $param;
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if (false === $result){
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
}