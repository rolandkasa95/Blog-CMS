<?php namespace Models;

use Models\Model;
use PDO;

class Tag extends Model {
    private $id;
    
    private $name;

    public function __construct( $name = null, $id = null )
    {
        $this->setName($name);
        $this->setId($id);
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getByName( $name )
    {
        try{
            $this->connect();
            $query = "SELECT * FROM tags WHERE name=:name";
            $statement = $this->db->prepare($query);
            $statement->bindParam(":name",$this->name,PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getById()
    {
        try{
            $this->connect();
            $query = "SELECT * FROM tags WHERE tag_id=:tag_id";
            $statement = $this->db->prepare($query);
            $statement->bindParam(":tag_id",$this->id,PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public function save($value,$button)
    {
        if($this->inTable($this->name)) {
            $sql = "INSERT INTO tags(name,isVisible) VALUES (:name,:isVisible)";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':name', $value,  PDO::PARAM_STR, 100);
            $statement->bindParam(':isVisible', $button, PDO::PARAM_BOOL);
            $statement->execute();
            return true;
        }else{
            return false;
        }
    }

    public function deleteById($tagToManage)
    {
        try{
            $this->connect();
            $delete = filter_var($tagToManage,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $delete = trim($delete,' ');
            $query = "DELETE FROM tags WHERE tag_id=:tag_id";
            $statement = $this->db->prepare($query);
            $statement->bindParam('tag_id',$this->getTagId($delete),PDO::PARAM_INT);
            $statement->execute();
            return true;
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function update($tagToManage)
    {
        try{
            $this->connect();
            $update = filter_var($tagToManage,FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $update = trim($update,' ');
            $updateTo = filter_input(INPUT_POST,'updateTo',FILTER_SANITIZE_STRING,FILTER_FLAG_ENCODE_LOW);
            $updateTo = trim($updateTo,' ');
            $sql = "Update tags SET name=:name WHERE tag_id=:id";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':name',$updateTo,PDO::PARAM_STR,100);
            $statement->bindParam(':id',$this->getTagId($update),PDO::PARAM_INT);
            $statement->execute();
            return true;
        }catch(\PDOException $e){
            echo $e->getMessage();
        }
    }

}