<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}
function asset(string $path): string
{
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}
