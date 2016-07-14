<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 07.07.2016
 * Time: 17:34
 */

namespace Models;


class tagpageModel
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

    public function getArticleId($row){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql = 'SELECT article_id FROM articles WHERE isPublished=1 AND title="' . $row . '"';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_COLUMN);
        return $result;
    }
}