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
            $sql = 'SELECT * FROM articles DESC LIMIT :limit, 10';
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':limit',$this->getLimit(),PDO::PARAM_INT);
            $stmt->execute();
            $this->articleArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }


}