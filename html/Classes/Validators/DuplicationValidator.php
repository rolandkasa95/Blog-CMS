<?php

namespace Validators;

class DuplicationValidator implements ValidatorInterface
{
    protected $db;
    protected $config;

    /**
     * Duplication constructor.
     *
     * Gets config file to connect to the database
     */
    public function __construct()
    {
        $this->config = \ObjectFactoryService::getConfig();
    }

    public function connect(){
        if( ! isset($this->db)) {
            try {
                $configError = [\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION];
                $this->db = new \PDO($this->config['db']['dsn'],
                    $this->config['db']['user'],
                    $this->config['db']['pass'],
                    $configError);
            } catch (\PDOException $e) {
                echo 'Failed connection' . $e->getMessage();
            }
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
        $this->connect();
        $sql = "SELECT username FROM users WHERE username='" . $value . "'";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return empty($result);
    }
}