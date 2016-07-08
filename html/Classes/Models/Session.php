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
    public function __construct()
    {
        session_start();
    }

    public function init(){
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['password'] = $_POST['password'];
    }

    public function get(){
        return $_SESSION;
    }
}