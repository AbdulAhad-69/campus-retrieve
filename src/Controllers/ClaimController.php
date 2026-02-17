<?php
// src/Controllers/ClaimController.php
require_once __DIR__ . '/../Models/Claim.php';
require_once __DIR__ . '/../Models/Item.php'; // 1. Load Item Model

class ClaimController
{

    private $db;
    private $claimModel;
    private $itemModel; // 2. Add property

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /campus-retrieve/public/login");
            exit;
        }
        $this->db = Database::getInstance();
        $this->claimModel = new Claim($this->db);
        $this->itemModel = new Item($this->db); // 3. Initialize it
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item_id = $_POST['item_id'];
            $message = trim($_POST['message'] ?? '');
            $user_id = $_SESSION['user_id'];

            // 4. SECURITY CHECK: Is the item already resolved?
            $item = $this->itemModel->getById($item_id);
            if ($item['status'] == 'Resolved') {
                // Kick them back with an error
                header("Location: /campus-retrieve/public/item?id=$item_id&error=item_resolved");
                exit;
            }

            // Prevent duplicate claims
            if ($this->claimModel->alreadyClaimed($item_id, $user_id)) {
                header("Location: /campus-retrieve/public/item?id=$item_id&error=already_claimed");
                exit;
            }

            if ($this->claimModel->create($item_id, $user_id, $message)) {
                header("Location: /campus-retrieve/public/item?id=$item_id&success=claimed");
            } else {
                echo "Error submitting claim.";
            }
        }
    }
}
