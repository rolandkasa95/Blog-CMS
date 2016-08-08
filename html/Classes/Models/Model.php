<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 14.07.2016
 * Time: 16:00
 */

namespace Models;

use PDO;
USE PDOException;

/**
 * Class Model
 * @package Models
 */
class Model
{
    /**
     * @var \PDO
     */
    protected $db;

    /**
     * Connection to database
     */
    public function connect(){
        try {
            $config = \ObjectFactoryService::getConfig();
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }
    
}