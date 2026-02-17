<?php
// src/Controllers/ProfileController.php
require_once __DIR__ . '/../Models/Item.php';

class ProfileController
{

    private $db;
    private $itemModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /campus-retrieve/public/login");
            exit;
        }
        $this->db = Database::getInstance();
        $this->itemModel = new Item($this->db);
    }

    // Show My Profile
    public function index()
    {
        $user_id = $_SESSION['user_id'];
        $myItems = $this->itemModel->getByUser($user_id);
        require_once __DIR__ . '/../Views/profile/index.php';
    }

    // Handle Delete
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['item_id'];
            if ($this->itemModel->delete($id, $_SESSION['user_id'])) {
                header("Location: /campus-retrieve/public/profile?msg=deleted");
            } else {
                echo "Error deleting item.";
            }
        }
    }

    // Handle Resolve
    public function resolve()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['item_id'];
            if ($this->itemModel->markResolved($id, $_SESSION['user_id'])) {
                header("Location: /campus-retrieve/public/profile?msg=resolved");
            } else {
                echo "Error updating item.";
            }
        }
    }
}
