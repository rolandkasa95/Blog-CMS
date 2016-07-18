<?php

namespace Models;

/**
 * Created by PhpStorm.
 * User: roland
 * Date: 08.07.2016
 * Time: 12:13
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
        $_SESSION['offset']=0;
    }

    /**
     * Session init.
     */
    public function init(){
        $_SESSION['username'] = $_POST['username'];
    }

    /**
     * Returns the session variable
     *
     * @return array
     */
    public function get(){
        return $_SESSION;
    }

    /**
     * Destroys the session
     */
    public function destroy(){
        session_unset();
        session_destroy();
    }
}