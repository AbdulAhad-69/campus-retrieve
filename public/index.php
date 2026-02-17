<?php
// public/index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

    case '/post':
        // logic to load ItemController -> create() or store()
        require_once '../src/Controllers/ItemController.php';
        $controller = new ItemController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->store();
        } else {
            $controller->create();
        }
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

    case '/item':
        // logic to load ItemController -> show()
        require_once '../src/Controllers/ItemController.php';
        $controller = new ItemController();
        $controller->show();
        break;

    case '/browse':
        // logic to load ItemController -> index()
        require_once '../src/Controllers/ItemController.php';
        $controller = new ItemController();
        $controller->index();
        break;

    case '/profile':
        // logic to load ProfileController -> index()
        require_once '../src/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;

    case '/profile/delete':
        // logic to load ProfileController -> delete()
        require_once '../src/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->delete();
        break;

    case '/profile/resolve':
        // logic to load ProfileController -> resolve()
        require_once '../src/Controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->resolve();
        break;

    case '/claim/submit':
        require_once '../src/Controllers/ClaimController.php';
        $controller = new ClaimController();
        $controller->store();
        break;

    default:
        http_response_code(404);
        echo "<h1>404 Not Found</h1>";
        break;
}
