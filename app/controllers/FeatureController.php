<?php
require_once __DIR__ . '/../models/Feature.php';

class FeatureController
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
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $title = $_POST['title'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $icon = $_POST['current_icon'] ?? '';
                    if (isset($_FILES['icon']) && $_FILES['icon']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/icons/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['icon']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['icon']['tmp_name'], $destination)) {
                            $icon = 'assets/images/icons/' . $filename;
                        }
                    }
                    if ($id && $title && $description && $icon) {
                        Feature::update($id, $title, $description, $icon);
                    }
                    break;
            }
        }

        header('Location: index.php');
        exit;
    }
}
?>
