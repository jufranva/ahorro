<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/NuevaController.php';

$controller = new NuevaController();
$controller->index();
