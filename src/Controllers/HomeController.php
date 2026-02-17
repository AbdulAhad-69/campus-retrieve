<?php
// src/Controllers/HomeController.php

require_once __DIR__ . '/../Models/Item.php'; // Load the Item Model

class HomeController
{

    private $db;
    private $itemModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->itemModel = new Item($this->db);
    }

    public function index()
    {
        // 1. Security Check
        if (!isset($_SESSION['user_id'])) {
            header("Location: /campus-retrieve/public/login");
            exit;
        }

        // 2. Fetch Data
        $userName = $_SESSION['user_name'] ?? 'Student';
        $stats = $this->itemModel->getStats();
        $recentItems = $this->itemModel->getRecent();

        // 3. Load View
        require_once __DIR__ . '/../Views/home/index.php';
    }
}
