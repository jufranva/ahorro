<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/CartController.php';

$controller = new CartController();
$action = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['action'] ?? 'index') : ($_GET['action'] ?? 'index');

switch ($action) {
    case 'add':
        $controller->add();
        break;
    case 'remove':
        $controller->remove();
        break;
    case 'checkout':
        $controller->checkout();
        break;
    default:
        $controller->index();
        break;
}
