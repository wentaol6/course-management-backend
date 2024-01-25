<?php
class DatabaseManager {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // 在构造函数中创建数据库连接
        $this->Connect();
    }

    public static function GetInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function Connect() {
        // 直接使用已定义的数据库连接参数常量
        require_once 'config.php';
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // 检查连接是否成功
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    // 其他数据库操作方法可以根据需要添加

    public function GetConnection() {
        return $this->connection;
    }

    public function Query($sql) {
        return $this->connection->query($sql);
    }

    // 其他数据库操作方法...

    public function __destruct() {
        // 在析构函数中关闭数据库连接
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }
}


