<?php
class DatabaseManager {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->Connect();
    }

    public static function GetInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function Connect() {
        // get configuration
        require_once 'config.php';
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function GetConnection() {
        return $this->connection;
    }

    public function Query($sql) {
        return $this->connection->query($sql);
    }


    public function __destruct() {
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
}


