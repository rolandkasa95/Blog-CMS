<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 26.07.2016
 * Time: 14:12
 */

namespace Models;

use PDO;
use PDOException;


class Article extends Model
{
    private $title;
    private $id;
    private $body;
    private $urlImage;
    private $tag;

    public function __construct($param = null)
    {
        if(is_integer($param)){
            $this->setId($param);
        }elseif (is_string($param)){
            $this->setTitle($param);
        }
    }

    /**
     * @return mixed
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * @param mixed $urlImage
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getById()
    {
        try{
            $this->connect();
            $query = "SELECT * FROM articles WHERE article_id=:article_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam('article_id',$this->id,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public function getByTitle()
    {
        try{
            $this->connect();
            $qurey = "SELECT article_id FROM articles WHERE title=:title";
            $stmt = $this->db->prepare($qurey);
            $stmt->bindParam(":title",$this->title,PDO::PARAM_STR,100);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public function save($bool)
    {
        session_start();
        $date = new \DateTime();
        $user = new User($_SESSION['username']);
        $date->modify('+3 hours');
        if($this->id){
            try {
                $this->connect();
                if("/Layouts/uploads/" === $this->urlImage){
                    $sql = "UPDATE articles SET user_id=:user_id, title=:title, author=:author, body=:body, date=:date, isPublished=:isPublished WHERE article_id=:id";
                    $insert = $this->db->prepare($sql);
                    $insert->bindParam(':user_id', $user->getId(), PDO::PARAM_INT);
                    $insert->bindParam(':title', trim($this->title, ' '), PDO::PARAM_STR, 100);
                    $insert->bindParam(':author', $_SESSION['username'], PDO::PARAM_STR, 100);
                    $insert->bindParam(':body', trim($this->body, ' '), PDO::PARAM_STR, 100);
                    $insert->bindParam(':date', $date->format('Y-m-d H:i:sP'));
                    $insert->bindParam('isPublished', $bool, PDO::PARAM_BOOL);
                    $insert->bindParam(':id', $this->id, PDO::PARAM_INT);
                    $insert->execute();
                    return;
                }else {
                    $sql = "UPDATE articles SET user_id=:user_id, title=:title, author=:author, body=:body, date=:date, isPublished=:isPublished, imagePath=:imagePath WHERE article_id=:id";
                    $insert = $this->db->prepare($sql);
                    $insert->bindParam(':user_id', $user->getId(), PDO::PARAM_INT);
                    $insert->bindParam(':title', trim($this->title, ' '), PDO::PARAM_STR, 100);
                    $insert->bindParam(':author', $_SESSION['username'], PDO::PARAM_STR, 100);
                    $insert->bindParam(':body', trim($this->body, ' '), PDO::PARAM_STR, 100);
                    $insert->bindParam(':date', $date->format('Y-m-d H:i:sP'));
                    $insert->bindParam('isPublished', $bool, PDO::PARAM_BOOL);
                    $insert->bindParam(':imagePath', $this->urlImage, 200);
                    $insert->bindParam(':id', $this->id, PDO::PARAM_INT);
                    $insert->execute();
                    return;
                }
            }catch (\PDOException $e){
                echo $e->getMessage();
            }
        }elseif($this->checkInTable('title="' . $this->title . '"')){
            try{
                $this->connect();
                $sql="INSERT INTO articles(user_id,title,author,body,date,isPublished,imagePath) VALUES (:user_id,:title,:author,:body,:date,:isPublished,:imagePath)";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':user_id',$user->getId(),PDO::PARAM_INT);
                $insert->bindParam(':title',trim($this->title,' '),PDO::PARAM_STR,100);
                $insert->bindParam(':author',$_SESSION['username'],PDO::PARAM_STR,100);
                $insert->bindParam(':body',trim($this->body,' '),PDO::PARAM_STR,100);
                $insert->bindParam(':date',$date->format('Y-m-d H:i:sP'));
                $insert->bindParam('isPublished',$bool,PDO::PARAM_BOOL);
                $insert->bindParam(':imagePath',$this->urlImage,200);
                $insert->execute();
            }catch (PDOException $e){
                echo $e->getMessage();
            }
        }
    }

    public function delete()
    {
        try{
            $this->connect();
            $query = "DELETE FROM articles WHERE title=:title";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam('title',$this->title,PDO::PARAM_STR,100);
            $stmt->execute();
        }catch (PDOException $e){
            echo $e->getMessage();
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

    public function saveArticleTags()
    {
        if($this->id){
            $this->connect();
            $sql = "DELETE FROM articles_tags WHERE article_id=:article_id";
            $insert = $this->db->prepare($sql);
            $insert->bindParam('article_id',$this->id,PDO::PARAM_INT);
            $insert->execute();
            for($j=0;$j<=$this->count();$j++){
                $tags = 'tags_' . $j;
                if (isset($_POST[$tags])) {
                    $sql = "INSERT INTO articles_tags (article_id,tag_id) VALUES (:article_id,:tag_id)";
                    $insert = $this->db->prepare($sql);
                    $insert->bindParam(':article_id', $this->id, PDO::PARAM_INT);
                    $insert->bindParam(':tag_id',$this->getTagId(trim($_POST[$tags]),' '),PDO::PARAM_INT);
                    $insert->execute();
                }
            }
        }
        try {
            $this->connect();
            $articleTag = new Tag();
            $tags = explode(',',$this->tag);
            foreach ($tags as $tag) {
                $tag = trim($tag,' ');
                $articleTag->setName($tag);
                $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':article_id', $this->getByTitle()['article_id'], PDO::PARAM_INT);
                $insert->bindParam(':tag_id', $articleTag->getByName()['tag_id'], PDO::PARAM_INT);
                $insert->execute();
            }
            return;
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * Checks if the article is in the table or not
     *
     * @param $param
     * @return bool
     */
    public function checkInTable($param){
        try{
            $this->connect();
            $sql = "SELECT article_id FROM articles WHERE " . $param;
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

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }
}