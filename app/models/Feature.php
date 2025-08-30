<?php
require_once __DIR__ . '/../../conexion.php';

class Feature
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, title, description, icon FROM features');
        $features = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $features;
    }

    public static function create(string $title, string $description, string $icon): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO features (title, description, icon) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $title, $description, $icon);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $title, string $description, string $icon): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE features SET title = ?, description = ?, icon = ? WHERE id = ?');
        $stmt->bind_param('sssi', $title, $description, $icon, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('DELETE FROM features WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
