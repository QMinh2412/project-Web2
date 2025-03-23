<?php

class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        // Nạp file cấu hình
        $config = require __DIR__ . '/../config/config.php';

        // Kiểm tra cấu hình
        if (!is_array($config) || !isset($config['host'], $config['username'], $config['pass'], $config['dbname'])) {
            die("Lỗi: Cấu hình database không hợp lệ.");
        }

        // Kết nối MySQLi
        $this->conn = new mysqli($config['host'], $config['username'], $config['pass'], $config['dbname']);

        // Kiểm tra lỗi kết nối
        if ($this->conn->connect_error) {
            die("Lỗi kết nối CSDL: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
?>
