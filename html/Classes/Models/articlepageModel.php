<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 07.07.2016
 * Time: 16:40
 */

namespace Models;

/**
 * Class articlepageModel
 * @package Models
 */
class articlepageModel
{
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function showArticle(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql='SELECT name,date,body FROM articles WHERE isPublished=1';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_COLUMN);
        var_dump($result);
        return $result;
    }
}