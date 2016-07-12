<?php

namespace Models;

USE \PDO;

class homepageModel
{

    protected $db;

    public function connect($config)
    {
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function getArticles($offset){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql = 'SELECT title,date FROM articles WHERE isPublished=1 LIMIT 5 OFFSET ' . $offset;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
        return $result;
    }

    public function getArticleId($row){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql = 'SELECT article_id FROM articles WHERE isPublished=1 AND title="' . $row . '"';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_COLUMN);
        return $result;
    }
}