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

        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }


}