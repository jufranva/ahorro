<?php
require_once __DIR__ . '/../../conexion.php';

class Category
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, name FROM categories');
        $categories = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $categories;
    }

    public static function create(string $name): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
