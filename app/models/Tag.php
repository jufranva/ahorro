<?php
require_once __DIR__ . '/../../conexion.php';

class Tag
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT t.id, t.text, t.bg_color, t.text_color, COUNT(g.id) AS usage_count'
             . ' FROM tags t LEFT JOIN garments g ON g.tag_id = t.id'
             . ' GROUP BY t.id, t.text, t.bg_color, t.text_color';
        $result = $mysqli->query($sql);
        $tags = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $tags;
    }

    public static function create(string $text, string $bgColor, string $textColor): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO tags (text, bg_color, text_color) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $text, $bgColor, $textColor);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $text, string $bgColor, string $textColor): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE tags SET text = ?, bg_color = ?, text_color = ? WHERE id = ?');
        $stmt->bind_param('sssi', $text, $bgColor, $textColor, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $check = $mysqli->prepare('SELECT COUNT(*) FROM garments WHERE tag_id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();
        if ($count > 0) {
            $mysqli->close();
            return false;
        }
        $stmt = $mysqli->prepare('DELETE FROM tags WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>

