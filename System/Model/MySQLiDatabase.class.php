<?php

require(SYSTEM . 'Exceptions/DatabaseExceptions.class.php');

class MySQLiDatabase{
    public $MySQLi;

    protected $host;
    protected $user;
    protected $password;
    protected $database;

    function __construct($host, $user, $password, $database){
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;

        $this->connect();
        $this->selectDatabase();
    }

    protected function connect()
    {
        try {
            $this-> MySQLi = new MySQLi($this->host, $this->user, $this->password, $this->database);
            if ($this->MySQLi->connect_errno) {
                throw new DatabaseException('Connecting to MySQL server: ' . $this->host . ' unsuccessfull!');
            }
        }catch (Exception $e){
            throw new DatabaseException('Connecting to MySQL server: ' . $this->host . ' unsuccessfull! Error: ' . $e->getMessage());
        }
    }

    protected function selectDatabase()
    {
        if ($this->MySQLi->select_db($this->database) === false) {
            throw new DatabaseException('Cant use this database: ' . $this->database);
        }
    }

    public function sendQuery($sql){
        $this->result = $this->MySQLi->query($sql);
        if ($this->result === false) {
            throw new DatabaseException('Query: ' . $sql . ' unsuccessfull!');
        }
        return $this->result;
    }

    function fetchArray($result){
        return $result->fetch_array();
    }

    function escapeString($string) {
        return $this->MySQLi->escape_string($string);
    }
}






































