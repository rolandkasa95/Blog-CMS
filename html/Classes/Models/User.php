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


    

}