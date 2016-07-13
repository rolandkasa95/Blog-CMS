<?php

namespace Models;

Use PDO;

class insertTag
{
    /**
     * @var PDO
     */
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
                    $value = trim($value,' ');
                    if($this->inTable($value)) {
                        $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
                        $statement = $this->db->prepare($sql);
                        $statement->bindParam(':name', $value,  PDO::PARAM_STR, 100);
                        $statement->bindParam(':isVisible', $button, PDO::PARAM_BOOL);
                        $statement->execute();
                    }
                }
            }else{
                $value = trim($_POST['tag'],' ');
                if($this->inTable($tags)) {
                    $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
                    $statement = $this->db->prepare($sql);
                    $statement->bindParam(':name', $value, PDO::PARAM_STR, 100);
                    $statement->bindParam(':isVisible', $button, PDO::PARAM_BOOL);
                    $statement->execute();
                }
            }
            return;
        }catch (\PDOException $e){
            echo "Transaction Failed: " . $e->getMessage();
        }
    }

    public function inTable($tags){
        try{
            $this->connect(\ObjectFactoryService::getConfig());
            $sql = "SELECT tag_id FROM tags WHERE name=:name";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':name',$tags,PDO::PARAM_STR,100);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_COLUMN);
            if(empty($result)){
                return true;
            }else{
                return false;
            }
        }catch (\PDOException $e){
            echo "Transaction failed" . $e->getMessage();
        }
    }

}