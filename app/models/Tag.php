<?php
require_once __DIR__ . '/../../conexion.php';

class Tag
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, text, color FROM tags');
        $tags = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $tags;
    }

    public static function create(string $text, string $color): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO tags (text, color) VALUES (?, ?)');
        $stmt->bind_param('ss', $text, $color);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
