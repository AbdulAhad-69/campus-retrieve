<?php
// src/Controllers/HomeController.php

class HomeController {
    
    public function index() {
        // 1. Security Check (Middleware logic)
        // If user is NOT logged in, kick them back to login
        if (!isset($_SESSION['user_id'])) {
            header("Location: /campus-retrieve/public/login");
            exit;
        }

        // 2. Get User Info from Session
        $userName = $_SESSION['user_name'] ?? 'Student';
        
        // 3. Load the View
        // We pass variables to the view by setting them here
        $pageTitle = "Dashboard";
        require_once __DIR__ . '/../Views/home/index.php';
    }
}
?>