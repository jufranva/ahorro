<?php
require_once __DIR__ . '/../../conexion.php';

class Slide
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, title, description, image, link FROM slides');
        $slides = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $slides;
    }

    public static function create(string $title, string $description, string $image, string $link): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO slides (title, description, image, link) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $title, $description, $image, $link);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $title, string $description, string $image, string $link): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE slides SET title = ?, description = ?, image = ?, link = ? WHERE id = ?');
        $stmt->bind_param('ssssi', $title, $description, $image, $link, $id);
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
}
