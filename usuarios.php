<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/UserController.php';

require_login();

$controller = new UserController();
$controller->index();
