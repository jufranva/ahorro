<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/PedidoController.php';

$controller = new PedidoController();
$action = $_SERVER['REQUEST_METHOD'] === 'POST' ? ($_POST['action'] ?? 'index') : ($_GET['action'] ?? 'index');

switch ($action) {
    case 'confirm':
        $controller->confirm();
        break;
    case 'pay':
        $controller->pay();
        break;
    case 'credit':
        $controller->credit();
        break;
    case 'deliver':
        $controller->deliver();
        break;
    case 'reject':
        $controller->reject();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
        break;
}
