<?php

namespace Models;
use PDO;

class Articles extends Model
{

    public $articleArray = [];

    public $limit = 0;

    /**
     * @return array
     */
    public function getArticleArray()
    {
        return $this->articleArray;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function getAll(){
        try{
            $this->connect();
            $sql = 'SELECT * FROM articles';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $this->articleArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getWithLimitation(){
        try{
            $this->connect();
            $sql = 'SELECT * FROM articles ORDER BY date DESC LIMIT :limit, 5';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit',$this->getLimit(),PDO::PARAM_INT);
            $stmt->execute();
            $this->articleArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    /**
     * @param $name tag name
     * @return array
     */
    public function getWithSelectedTag($name){
        try{
            $this->connect();
            $sql = 'SELECT title,date FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id  WHERE tags.name=:tag_name AND articles.isPublished=1 AND tags.isVisible=1 ORDER BY date DESC';
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':tag_name',$name,PDO::PARAM_STR,100);
            $statement->execute();
            $this->articleArray = $statement->fetchAll(PDO::FETCH_ASSOC);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;

        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }


}