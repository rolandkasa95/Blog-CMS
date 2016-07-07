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

    public function getArticles(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql = 'SELECT title,date FROM articles WHERE isPublished=1';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_KEY_PAIR);
        var_dump($result);
        return $result;
    }
}