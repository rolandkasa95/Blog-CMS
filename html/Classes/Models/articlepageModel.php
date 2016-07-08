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
        $id = $_GET['id'];
        $sql='SELECT title,date,body FROM articles WHERE isPublished=1 AND article_id=' .$id ;
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function tagNameDisplay(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $id = $_GET['id'];
        $sql='SELECT name FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id WHERE articles.article_id=' .$id . ' AND articles.isPublished=1';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}