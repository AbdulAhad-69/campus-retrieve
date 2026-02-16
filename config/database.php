<?php
// config/database.php

class Database {
    private $host = 'localhost';
    private $db_name = 'uni_lost_found';
    private $username = 'root';
    private $password = '';
    public $conn;

    // Static instance for Singleton Pattern
    private static $instance = null;

    // Private constructor (stops you from using "new Database()")
    private function __construct() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            
            // Professional Settings
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Connection Failed: " . $e->getMessage());
        }
    }

    // This is the function your Controller is looking for!
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
?>