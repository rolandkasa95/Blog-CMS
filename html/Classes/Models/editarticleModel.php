<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 13.07.2016
 * Time: 16:07
 */

namespace Models;

use PDO;


class editarticleModel
{
    /**
     * @var \PDO
     */
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function showArticle(){
       try {
           $config = \ObjectFactoryService::getConfig();
           $this->connect($config);
           $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $sql = 'SELECT title,date,body FROM articles WHERE article_id=:id';
           $statement = $this->db->prepare($sql);
           $statement->bindParam(':id', $id, PDO::PARAM_INT);
           $statement->execute();
           $result = $statement->fetch(\PDO::FETCH_ASSOC);
           return $result;
       }catch (\PDOException $e){
           echo $e->getMessage();
       }
    }

    public function editTitle(){
       try {
           $config = \ObjectFactoryService::getConfig();
           $this->connect($config);
           $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
           $title = trim($title, ' ');
           $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
           $sql = 'UPDATE articles SET title=:title WHERE article_id=:id';
           $statement = $this->db->prepare($sql);
           $statement->bindParam(':id', $id, PDO::PARAM_INT);
           $statement->bindParam(':title',$title,PDO::PARAM_STR,100);
           $statement->execute();
       }catch (\PDOException $e){
           echo $e->getMessage();
       }
    }

}