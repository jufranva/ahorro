<?php
require_once __DIR__ . '/../../conexion.php';

class User
{
    public static function findByUsername(string $username): ?array
    {
        $mysqli = obtenerConexion();
        if ($stmt = $mysqli->prepare('SELECT username, password FROM users WHERE username = ?')) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();
            $mysqli->close();
            return $user ?: null;
        }
        $mysqli->close();
        return null;
    }
}
