<?php
// src/Controllers/ItemController.php
require_once __DIR__ . '/../Models/Item.php';
require_once __DIR__ . '/../Models/Claim.php'; // 1. Load Claim Model

class ItemController
{

    private $db;
    private $itemModel;
    private $claimModel; // 2. Add Property

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->itemModel = new Item($this->db);
        $this->claimModel = new Claim($this->db); // 3. Initialize
    }

    // Show the "Post Item" Form
    public function create()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /campus-retrieve/public/login");
            exit;
        }

        $categories = $this->itemModel->getCategories();
        require_once __DIR__ . '/../Views/items/create.php';
    }

    // Handle the Form Submission
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Handle File Upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $allowed = ['jpg', 'jpeg', 'png', 'webp'];
                $filename = $_FILES['image']['name'];
                $filesize = $_FILES['image']['size'];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

                if (in_array($ext, $allowed) && $filesize < 5000000) {
                    $newFilename = "item_" . $_SESSION['user_id'] . "_" . time() . "." . $ext;
                    $destination = __DIR__ . '/../../public/uploads/' . $newFilename;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                        $imagePath = $newFilename;
                    }
                }
            }

            // Prepare Data
            $data = [
                'user_id'     => $_SESSION['user_id'],
                'category_id' => $_POST['category_id'],
                'type'        => $_POST['type'],
                'title'       => trim($_POST['title']),
                'description' => trim($_POST['description']),
                'location'    => trim($_POST['location']),
                'image_path'  => $imagePath
            ];

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
            echo "Item not found.";
            return;
        }

        // 4. NEW LOGIC: If I am the owner, fetch the claims!
        $claims = [];
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $item['user_id']) {
            $claims = $this->claimModel->getClaimsByItem($id);
        }

        require_once __DIR__ . '/../Views/items/show.php';
    }

    // Browse/Search Page
    public function index()
    {
        $keyword = $_GET['q'] ?? '';
        $category = $_GET['category'] ?? '';
        $type = $_GET['type'] ?? '';

        $items = $this->itemModel->search($keyword, $category, $type);
        $categories = $this->itemModel->getCategories();

        require_once __DIR__ . '/../Views/items/index.php';
    }
}
