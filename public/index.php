<?php
// public/index.php

// 1. Start Session
session_start();

// 2. Load Config (Adjust path because we are in /public)
require_once '../config/database.php';

// 3. Simple Routing Logic
$request = $_SERVER['REQUEST_URI'];
// Remove the project folder name from the request to get the path
$base_path = '/campus-retrieve/public';
$path = str_replace($base_path, '', $request);

// Remove query strings (like ?id=1)
$path = strtok($path, '?');

// 4. Route Switcher
switch ($path) {
    case '/':
    case '/home':
        // logic to load HomeController -> index()
        require_once '../src/Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
        
    case '/login':
        // logic to load AuthController -> login()
        require_once '../src/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case '/register':
        // logic to load AuthController -> register()
        require_once '../src/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
    
    case '/logout':
        // logic to load AuthController -> logout()
        require_once '../src/Controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}
?>