<?php
require_once __DIR__ . '/../models/Garment.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Tag.php';
require_once __DIR__ . '/../models/State.php';

class PrendaController
{
    public function handle(): void
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: inicio.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            switch ($action) {
                case 'create':
                    $name = $_POST['name'] ?? '';
                    $purchase = isset($_POST['purchase_value']) ? (float)$_POST['purchase_value'] : 0;
                    $sale = isset($_POST['sale_value']) ? (float)$_POST['sale_value'] : 0;
                    if ($sale < $purchase) {
                        $sale = $purchase;
                    }
                    $code = $_POST['unique_code'] ?? '';
                    $condition = isset($_POST['condition']) ? max(0, min(100, (int)$_POST['condition'])) : 0;
                    $size = $_POST['size'] ?? '';
                    $comment = $_POST['comment'] ?? '';
                    $type = $_POST['type'] ?? 'nueva';
                    $category = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
                    $tag = isset($_POST['tag_id']) ? (int)$_POST['tag_id'] : null;
                    $state = isset($_POST['state_id']) ? (int)$_POST['state_id'] : null;
                    $purchaseDate = $_POST['purchase_date'] ?? null;
                    $saleDate = $_POST['sale_date'] ?? null;

                    $imagePrimary = '';
                    if (isset($_FILES['image_primary']) && $_FILES['image_primary']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/prendas/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image_primary']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image_primary']['tmp_name'], $destination)) {
                            $imagePrimary = 'assets/images/prendas/' . $filename;
                        }
                    }
                    $imageSecondary = '';
                    if (isset($_FILES['image_secondary']) && $_FILES['image_secondary']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/prendas/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image_secondary']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image_secondary']['tmp_name'], $destination)) {
                            $imageSecondary = 'assets/images/prendas/' . $filename;
                        }
                    }
                    if ($name && $imagePrimary && $imageSecondary) {
                        Garment::create($name, $imagePrimary, $imageSecondary, $purchase, $sale, $code, $condition, $size, $comment, $type, $category, $tag, $state, $purchaseDate, $saleDate);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $name = $_POST['name'] ?? '';
                    $purchase = isset($_POST['purchase_value']) ? (float)$_POST['purchase_value'] : 0;
                    $sale = isset($_POST['sale_value']) ? (float)$_POST['sale_value'] : 0;
                    if ($sale < $purchase) {
                        $sale = $purchase;
                    }
                    $code = $_POST['unique_code'] ?? '';
                    $condition = isset($_POST['condition']) ? max(0, min(100, (int)$_POST['condition'])) : 0;
                    $size = $_POST['size'] ?? '';
                    $comment = $_POST['comment'] ?? '';
                    $type = $_POST['type'] ?? 'nueva';
                    $category = isset($_POST['category_id']) ? (int)$_POST['category_id'] : null;
                    $tag = isset($_POST['tag_id']) ? (int)$_POST['tag_id'] : null;
                    $state = isset($_POST['state_id']) ? (int)$_POST['state_id'] : null;
                    $purchaseDate = $_POST['purchase_date'] ?? null;
                    $saleDate = $_POST['sale_date'] ?? null;

                    $imagePrimary = $_POST['current_image_primary'] ?? '';
                    if (isset($_FILES['image_primary']) && $_FILES['image_primary']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/prendas/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image_primary']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image_primary']['tmp_name'], $destination)) {
                            $imagePrimary = 'assets/images/prendas/' . $filename;
                        }
                    }
                    $imageSecondary = $_POST['current_image_secondary'] ?? '';
                    if (isset($_FILES['image_secondary']) && $_FILES['image_secondary']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/prendas/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image_secondary']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image_secondary']['tmp_name'], $destination)) {
                            $imageSecondary = 'assets/images/prendas/' . $filename;
                        }
                    }
                    if ($id && $name && $imagePrimary && $imageSecondary) {
                        Garment::update($id, $name, $imagePrimary, $imageSecondary, $purchase, $sale, $code, $condition, $size, $comment, $type, $category, $tag, $state, $purchaseDate, $saleDate);
                    }
                    break;
                case 'delete':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        Garment::delete($id);
                    }
                    break;
                case 'create_category':
                    $name = $_POST['name'] ?? '';
                    if ($name) {
                        Category::create($name);
                    }
                    break;
                case 'update_category':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $name = $_POST['name'] ?? '';
                    if ($id && $name) {
                        Category::update($id, $name);
                    }
                    break;
                case 'delete_category':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        Category::delete($id);
                    }
                    break;
                case 'create_tag':
                    $text = $_POST['text'] ?? '';
                    $color = $_POST['color'] ?? '#000000';
                    if ($text) {
                        Tag::create($text, $color);
                    }
                    break;
                case 'update_tag':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $text = $_POST['text'] ?? '';
                    $color = $_POST['color'] ?? '#000000';
                    if ($id && $text) {
                        Tag::update($id, $text, $color);
                    }
                    break;
                case 'delete_tag':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        Tag::delete($id);
                    }
                    break;
                case 'create_state':
                    $name = $_POST['name'] ?? '';
                    if ($name) {
                        State::create($name);
                    }
                    break;
                case 'update_state':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $name = $_POST['name'] ?? '';
                    if ($id && $name) {
                        State::update($id, $name);
                    }
                    break;
                case 'delete_state':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        State::delete($id);
                    }
                    break;
            }
            header('Location: prendas.php');
            exit;
        }

        $garments = Garment::all();
        $categories = Category::all();
        $tags = Tag::all();
        $states = State::all();
        include __DIR__ . '/../views/prendas.php';
    }
}
?>
