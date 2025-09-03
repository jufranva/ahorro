<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/BannerController.php';

$controller = new BannerController();
$controller->handle();
