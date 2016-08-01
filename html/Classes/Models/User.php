<?php

namespace Models;


class User extends Model
{
    /**
     *
     * Username storing
     *
     */
    private $username;

    private $user_id;

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

    public function getUser($param){
        try{
            $this->connect();
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