<?php
require_once __DIR__ . '/../../conexion.php';

class Banner
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, title, subtitle, image, link, color FROM banners');
        $banners = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $banners;
    }

    public static function create(string $title, string $subtitle, string $image, string $link, int $color): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO banners (title, subtitle, image, link, color) VALUES (?, ?, ?, ?, ?)');
        $stmt->bind_param('ssssi', $title, $subtitle, $image, $link, $color);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $title, string $subtitle, string $image, string $link, int $color): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE banners SET title = ?, subtitle = ?, image = ?, link = ?, color = ? WHERE id = ?');
        $stmt->bind_param('ssssii', $title, $subtitle, $image, $link, $color, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

  
}
