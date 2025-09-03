<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/controllers/FeatureController.php';

$controller = new FeatureController();
$controller->handle();
?>
