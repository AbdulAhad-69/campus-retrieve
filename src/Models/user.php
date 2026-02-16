<?php
// src/Models/User.php

class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Verify User Credentials
    public function login($student_id, $password) {
        // 1. Find user by Student ID
        $query = "SELECT * FROM " . $this->table . " WHERE student_id = :student_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();

        // 2. Fetch the row
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // 3. Verify Password Hash
            // Note: Use password_verify() in production. 
            // For now, if you manually inserted a user in DB with plain text, use simple compare.
            // But we will build a Register page that hashes it.
            if (password_verify($password, $row['password'])) {
                return $row;
            }
        }
        return false; // Login failed
    }

    // Register New User
    public function register($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (student_id, full_name, email, password, phone) 
                  VALUES (:student_id, :full_name, :email, :password, :phone)";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash the password securely
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bindParam(':student_id', $data['student_id']);
        $stmt->bindParam(':full_name', $data['full_name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':phone', $data['phone']);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            return false; // Likely duplicate ID/Email
        }
    }
}
?>