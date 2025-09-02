<?php
function obtenerConexion(): mysqli
{
    $mysqli = new mysqli('localhost', 'root', '', 'ahorro');
    if ($mysqli->connect_errno) {
        throw new Exception('Error de conexión a la base de datos.');
    }
        $mysqli->set_charset('utf8mb4');
    return $mysqli;
}
