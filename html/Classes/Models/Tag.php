<?php namespace Models;

use Models\Model;
use PDO;

class Tag extends Model {
    private $id;
    
    private $name;

    public function __construct( $name = null, $id = null )
    {
        $this->setId($id);
        $this->setName($name);
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
        $query = 'query';
        
        return $this;
    }

    public function getById()
    {
        try{
            $this->connect();
            $query = "SELECT * FROM tags WHERE name=:name";
            $statement = $this->db->prepare($query);
            $statement->bindParam(":name",$this->name,PDO::PARAM_STR,100);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }catch (\PDOException $e){
            echo $e->getMessage();
        }
    }
    
    public function save()
    {

        return true;
    }

    public function delete()
    {
            
    }

    public function insert()
    {
        
    }

}