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
        $config = \ObjectFactoryService::getConfig();
        $this->connect($config);
        $title = filter_input(INPUT_GET,'title',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
        $title = trim($title,' ');
        $sql='SELECT title,date,body FROM articles WHERE title=:title';
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':title',$title,PDO::PARAM_STR,100);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

}