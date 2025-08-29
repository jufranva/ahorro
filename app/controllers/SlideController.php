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
                    $image = $_POST['image'] ?? '';
                    $link = $_POST['link'] ?? '';
                    if ($title && $description && $image && $link) {
                        Slide::create($title, $description, $image, $link);
                    }
                    break;
                case 'update':
                    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
                    $title = $_POST['title'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $image = $_POST['image'] ?? '';
                    $link = $_POST['link'] ?? '';
                    if ($id && $title && $description && $image && $link) {
                        Slide::update($id, $title, $description, $image, $link);
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
