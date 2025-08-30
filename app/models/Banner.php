<?php
require_once __DIR__ . '/../../conexion.php';

class Banner
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, title, subtitle, image, link FROM banners');
        $banners = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $banners;
    }

    public static function create(string $title, string $subtitle, string $image, string $link): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO banners (title, subtitle, image, link) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $title, $subtitle, $image, $link);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $title, string $subtitle, string $image, string $link): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE banners SET title = ?, subtitle = ?, image = ?, link = ? WHERE id = ?');
        $stmt->bind_param('ssssi', $title, $subtitle, $image, $link, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('DELETE FROM banners WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
