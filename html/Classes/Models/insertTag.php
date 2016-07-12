<?php

namespace Models;

Use PDO;

class insertTag
{
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function insertTag(){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $button = $_POST['submit'] ?1:0;
            $tags = filter_input(INPUT_POST,'tag',FILTER_SANITIZE_STRING);

            if(strpos($tags,',')) {
                $tags = explode(',', $_POST['tag']);
                foreach ($tags as $key => $value) {
                    $this->inTable($value);
                    $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':name',$value,PDO::PARAM_STR,100);
                    $statement->bindParam(':isVisible',$button,PDO::PARAM_BOOL);
                    $statement->execute();
                }
            }else{
                $this->inTable($tags);
                $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
                $statement = $this->db->prepare($sql);
                $statement->bindParam(':name',$_POST['tag'],PDO::PARAM_STR,100);
                $statement->bindParam(':isVisible',$button,PDO::PARAM_BOOL);
                $statement->execute();
            }
        }catch (\PDOException $e){
            echo "Transaction Failed: " . $e->getMessage();
        }
    }

    public function inTable(){
        try{
            $this->connect(\ObjectFactoryService::getConfig());

        }catch (\PDOException $e
    }

}