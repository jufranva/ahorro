<?php
require_once __DIR__ . '/../models/Slide.php';

class SlideController
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
                    $title = $_POST['title'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $link = $_POST['link'] ?? '';
                    $link = $link ?: 'index.php';
                    $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 1;
                    $image = '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/slider/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $image = 'assets/images/slider/' . $filename;
                        }
                    }
                    if ($title && $description && $image) {
                        Slide::create($title, $description, $image, $link, $estado);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $title = $_POST['title'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $link = $_POST['link'] ?? '';
                    $link = $link ?: 'index.php';
                    $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 1;
                    $image = $_POST['current_image'] ?? '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/slider/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $image = 'assets/images/slider/' . $filename;
                        }
                    }
                    if ($id && $title && $description && $image) {
                        Slide::update($id, $title, $description, $image, $link, $estado);
                    }
                    break;
                case 'toggle':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $estado = isset($_POST['estado']) ? (int)$_POST['estado'] : 1;
                    if ($id) {
                        Slide::updateEstado($id, $estado);
                    }
                    break;
                case 'delete':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        Slide::delete($id);
                    }
                    break;
            }
        }
        header('Location: index.php');
        exit;
    }
}
