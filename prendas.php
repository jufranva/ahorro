<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/PrendaController.php';

require_login();

$controller = new PrendaController();
$controller->handle();
