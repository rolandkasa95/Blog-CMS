<?php
/**
 * Created by PhpStorm.
 * User: roland
 * Date: 11.07.2016
 * Time: 11:17
 */

namespace Models;


class selectTagsModel
{
    protected $db;

    public function connect($config){
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    public function selectTags(){
        $config = \ObjectFactoryService::getConfig();
        try{

        }catch(\PDOException $e){
            echo "Failed selection: " . $e->getMessage();
        }
    }
}