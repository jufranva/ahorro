<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/SlideController.php';

$controller = new SlideController();
$controller->handle();
