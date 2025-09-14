<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/CuentaController.php';

$controller = new CuentaController();
$controller->index();
