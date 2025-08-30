<?php
require_once __DIR__ . '/../models/Banner.php';

class BannerController
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
                    $subtitle = $_POST['subtitle'] ?? '';
                    $link = $_POST['link'] ?? '';
                    $link = $link ?: 'shop-grid.html';
                    $image = '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/banner/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $image = 'assets/images/banner/' . $filename;
                        }
                    }
                    if ($title && $subtitle && $image) {
                        Banner::create($title, $subtitle, $image, $link);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $title = $_POST['title'] ?? '';
                    $subtitle = $_POST['subtitle'] ?? '';
                    $link = $_POST['link'] ?? '';
                    $link = $link ?: 'shop-grid.html';
                    $image = $_POST['current_image'] ?? '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/../../assets/images/banner/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $filename = time() . '-' . basename($_FILES['image']['name']);
                        $destination = $uploadDir . $filename;
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            $image = 'assets/images/banner/' . $filename;
                        }
                    }
                    if ($id && $title && $subtitle && $image) {
                        Banner::update($id, $title, $subtitle, $image, $link);
                    }
                    break;
                case 'delete':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    if ($id) {
                        Banner::delete($id);
                    }
                    break;
            }
        }

        header('Location: index.php');
        exit;
    }
}
