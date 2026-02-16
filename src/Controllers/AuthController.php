<?php
// src/Controllers/AuthController.php

require_once __DIR__ . '/../Models/User.php';

class AuthController {
    
    private $db;
    private $userModel;

    public function __construct() {
        // 1. Get Database Connection
        $this->db = Database::getInstance();
        // 2. Load User Model
        $this->userModel = new User($this->db);
    }

    // Handle Login
    public function login() {
        $error = null;

        // A. If the user clicked "Sign In" (POST request)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Sanitize Inputs
            $student_id = trim($_POST['student_id'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // 2. Validate Inputs
            if (empty($student_id) || empty($password)) {
                $error = "Please fill in all fields.";
            } else {
                // 3. Attempt Login
                // We need to add this 'login' method to our User model next!
                $user = $this->userModel->login($student_id, $password);

                if ($user) {
                    // 4. Success! Start Session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['full_name'];
                    $_SESSION['role'] = $user['role'];

                    // 5. Redirect to Home
                    header("Location: /campus-retrieve/public/home");
                    exit;
                } else {
                    $error = "Invalid Student ID or Password.";
                }
            }
        }

        // B. Load the View (pass the error if any)
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    // Handle Registration
    public function register() {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 1. Collect Data
            $data = [
                'full_name'  => trim($_POST['full_name']),
                'student_id' => trim($_POST['student_id']),
                'phone'      => trim($_POST['phone']),
                'email'      => trim($_POST['email']),
                'password'   => trim($_POST['password'])
            ];

            // 2. Basic Validation
            if (empty($data['student_id']) || empty($data['password']) || empty($data['email'])) {
                $error = "All fields are required.";
            } else {
                // 3. Call Model to Create User
                // The register() method in User.php handles the hashing!
                if ($this->userModel->register($data)) {
                    // Success! Redirect to login
                    header("Location: /campus-retrieve/public/login?registered=1");
                    exit;
                } else {
                    $error = "Registration failed. Student ID or Email might already exist.";
                }
            }
        }

        // Load View
        require_once __DIR__ . '/../Views/auth/register.php';
    }

    // Handle Logout
    public function logout() {
        session_destroy();
        header("Location: /campus-retrieve/public/login");
        exit;
    }
}
?>