<?php
// src/Controllers/ItemController.php
require_once __DIR__ . '/../Models/Item.php';

class ItemController
{

    private $db;
    private $itemModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->itemModel = new Item($this->db);
    }

    // Show the "Post Item" Form
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /campus-retrieve/public/login");
            exit;
        }

        // Fetch categories to show in the dropdown
        $categories = $this->itemModel->getCategories();
        require_once __DIR__ . '/../Views/items/create.php';
    }

    // Handle the Form Submission
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. Handle File Upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $filename = $_FILES['image']['name'];
                $filetype = $_FILES['image']['type'];
                $filesize = $_FILES['image']['size'];

                // Get extension
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                // Validate
                if (in_array($ext, $allowed) && $filesize < 5000000) { // Max 5MB
                    // Generate unique name: item_USERID_TIMESTAMP.jpg
                    $newFilename = "item_" . $_SESSION['user_id'] . "_" . time() . "." . $ext;
                    $destination = __DIR__ . '/../../public/uploads/' . $newFilename;

                    if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        $imagePath = $newFilename;
                    }
                } else {
                    die("Error: Invalid file type or too large.");
                }
            }

            // 2. Prepare Data
            $data = [
                'user_id'     => $_SESSION['user_id'],
                'category_id' => $_POST['category_id'],
                'type'        => $_POST['type'],
                'title'       => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'location'    => trim($_POST['location']),
                'image_path'  => $imagePath
            ];

            // 3. Save to DB
            if ($this->itemModel->create($data)) {
                header("Location: /campus-retrieve/public/home?status=posted");
            } else {
                echo "Something went wrong.";
            }
        }
    }

    // Show Single Item Details
    public function show()
    {
        if (!isset($_GET['id'])) {
            header("Location: /campus-retrieve/public/home");
            exit;
        }

        $id = $_GET['id'];
        $item = $this->itemModel->getById($id);

        if (!$item) {
            echo "Item not found."; // We can make a pretty 404 page later
            return;
        }

        require_once __DIR__ . '/../Views/items/show.php';
    }
}
