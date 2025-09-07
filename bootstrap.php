<?php
if (!defined('BASE_URL')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($base === '.' || $base === '/') {
        $base = '';
    }
    define('BASE_URL', $base);
}

$cookiePath = BASE_URL === '' ? '/' : BASE_URL;
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params(['path' => $cookiePath]);
    session_start();
}

require_once __DIR__ . '/app/models/Cart.php';
Cart::purgeExpired();

function asset(string $path): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
