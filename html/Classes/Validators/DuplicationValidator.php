<?php

namespace Validators;

class DuplicationValidator implements ValidatorInterface
{
    protected $db;

    public function connect($config)
    {
        try {
            $this->db = new \PDO($config['dsn'], $config['user'], $config['pass']);
        }catch (\PDOException $e){
            echo "error: " . $e->getMessage();
        }
    }

    /**
     * This function checks if the user is in the database,
     * not to register that again!
     *
     * @param $value
     * @return bool
     */
    public function validate($value)
    {
        $this->connect(\ObjectFactoryService::getConfig());
        $sql = "SELECT title FROM article WHERE title='" . $value . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_COLUMN);
        return empty($result);
    }
}