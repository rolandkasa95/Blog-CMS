<?php

namespace Models;
use PDO;


class User extends Model
{
    /**
     *
     * Username storing
     *
     */
    private $username;

    private $user_id;

    public function __construct($param = null)
    {
        if(is_string($param)){
            $this->setUsername($param);
        }
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUser(){
        try{
            $this->connect();
            $sql = "SELECT * FROM users WHERE  username=:username";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':username',$this->getUsername(),PDO::PARAM_STR,100);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($result && password_verify($_POST['password'], $result['password'])){
                return $result;
            }else{
                return false;
            }
        }catch (\PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }

    public function getId()
    {
        try{
            $this->connect();
            $sql = "SELECT user_id FROM users WHERE  username=:username";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(':username',$this->getUsername(),PDO::PARAM_STR,100);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['user_id'];
        }catch (\PDOException $e){
            echo "ERROR: " . $e->getMessage();
        }
    }
    

}