<?php
require_once __DIR__ . '/../../conexion.php';

class Slide
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, title, description, image, link, estado FROM slides');
        $slides = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $slides;
    }

    public static function create(string $title, string $description, string $image, string $link, int $estado = 1): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO slides (title, description, image, link, estado) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssi', $title, $description, $image, $link, $estado);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $title, string $description, string $image, string $link, int $estado = 1): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE slides SET title = ?, description = ?, image = ?, link = ?, estado = ? WHERE id = ?');
        $stmt->bind_param('ssssii', $title, $description, $image, $link, $estado, $id);
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
