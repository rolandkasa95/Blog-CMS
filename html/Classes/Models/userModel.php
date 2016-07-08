<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 08.07.2016
 * Time: 11:41
 */

namespace Models;

USE PDO;

class userModel
{
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function getUsername($param){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $sql = "SELECT * FROM users WHERE  username='" . $param ."'";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($result && password_verify($_POST['password'], $result['password'])){
                return true;
            }else{
                return false;
            }
        }catch (\PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
}