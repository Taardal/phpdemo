<?php
class DataSource {
    
    private static $hostname = "mysql";
    private static $username = "foo";
    private static $password = "bar";
    private static $database = "svitts";
    
    private $connection;

    public function __construct() {
         $this->connection = $this->createConnection();
    }
    
    public function __destruct() {
        $this->connection->close;
    }
    
    public function getConnection() {        
        return $this->connection;
    }
    
    private function createConnection() {
        return new mysqli(self::$hostname, self::$username, self::$password, self::$database);
    }
}