<?php
require_once __DIR__ . '/../../conexion.php';

class Slide
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, title, description, image, link, estado, color FROM slides');
        $slides = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $slides;
    }

    public static function create(string $title, string $description, string $image, string $link, int $estado = 1, int $color = 1): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO slides (title, description, image, link, estado, color) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssii', $title, $description, $image, $link, $estado, $color);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $title, string $description, string $image, string $link, int $estado = 1, int $color = 1): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE slides SET title = ?, description = ?, image = ?, link = ?, estado = ?, color = ? WHERE id = ?');
        $stmt->bind_param('ssssiii', $title, $description, $image, $link, $estado, $color, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('DELETE FROM slides WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function updateEstado(int $id, int $estado): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE slides SET estado = ? WHERE id = ?');
        $stmt->bind_param('ii', $estado, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
