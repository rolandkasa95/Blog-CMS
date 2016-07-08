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

    public function getArticles(){
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $sql = 'SELECT title FROM articles  INNER JOIN articles_tags ON articles.article_id = articles_tags.article_id INNER JOIN tags ON articles_tags.tag_id = tags.tag_id WHERE tags.name="' . $_GET['name'] . '" AND articles.isPublished=1 AND tags.isVisible=1';
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
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