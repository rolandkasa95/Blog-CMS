<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 11.07.2016
 * Time: 11:17
 */

namespace Models;

use PDO;

class selectTagsModel
{
    /**
     * @var $db PDO
     */
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function selectTags(){
        $config = \ObjectFactoryService::getConfig();
        try{
            $this->connect($config);
            $sql = 'SELECT * FROM tags';
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(\PDOException $e){
            echo "Failed selection: " . $e->getMessage();
        }
    }

    public function selectTags1(){
        $config = \ObjectFactoryService::getConfig();
        try{
            $this->connect($config);
            $sql = 'SELECT name FROM tags';
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_COLUMN);
            var_dump($result);
            return $result;
        }catch(\PDOException $e){
            echo "Failed selection: " . $e->getMessage();
        }
    }

}