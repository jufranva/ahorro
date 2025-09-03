<?php
require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/app/models/Garment.php';

try {
    $idRaw = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    if (!$idRaw) {
        header('Location: ' . asset('usada.php'), true, 302);
        exit;
    }
    $id = (int)$idRaw;
    $garment = Garment::find($id);
    if (!$garment) {
        http_response_code(404);
        include __DIR__ . '/404.php';
        exit;
    }
    include __DIR__ . '/app/views/prenda_detalle.php';
} catch (Throwable $e) {
    error_log($e->getMessage() . "\n", 3, __DIR__ . '/php-error.log');
    http_response_code(500);
    include __DIR__ . '/500.php';
}
