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

    public function getAllArticles()
    {
        try{
            $this->connect();
            $query = "SELECT title,article_id,date FROM articles ORDER BY date DESC LIMIT 10";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (PDOException $e){
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
        $date = new \DateTime();
        $date->modify('+3 hours');
        if($this->id){
            try {
                $this->connect();
                if("/Layouts/uploads/" === $this->urlImage){
                    $sql = "UPDATE articles SET user_id=:user_id, title=:title, author=:author, body=:body, date=:date, isPublished=:isPublished WHERE article_id=:id";
                    $insert = $this->db->prepare($sql);
                    $insert->bindParam(':user_id', $this->getIdFromUsers(), PDO::PARAM_INT);
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
                    $insert->bindParam(':user_id', $this->getIdFromUsers(), PDO::PARAM_INT);
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
        }else{
            try{
                $this->connect();
                $sql="INSERT INTO articles(user_id,title,author,body,date,isPublished,imagePath) VALUES (:user_id,:title,:author,:body,:date,:isPublished,:imagePath)";
                $insert = $this->db->prepare($sql);
                $insert->bindParam(':user_id',$this->getIdFromUsers(),PDO::PARAM_INT);
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

    public function insertArticlesTags()
    {
        try {
            $this->connect();
            $articleTag = new Tag();
            $articleTag->setName($this->tag);
            $sql = "INSERT INTO articles_tags(article_id,tag_id) VALUES (:article_id,:tag_id)";
            $insert = $this->db->prepare($sql);
            $insert->bindParam(':article_id', $this->getByTitle(), PDO::PARAM_INT);
            $insert->bindParam(':tag_id', $articleTag->getByName(), PDO::PARAM_INT);
            $insert->execute();
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