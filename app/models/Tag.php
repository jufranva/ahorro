<?php
require_once __DIR__ . '/../../conexion.php';

class Tag
{
    // Paleta de colores predefinida para las etiquetas
    private static $palette = [
        'amarillo' => ['#FFDC55', '#000000'],
        'azul'     => ['#002a51', '#ffffff'],
        'rojo'     => ['#FF2F2F', '#ffffff'],
        'verde'    => ['#009F0A', '#ffffff'],
    ];

    public static function palette(): array
    {
        return self::$palette;
    }

    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT t.id, t.text, t.color, COUNT(g.id) AS usage_count'
             . ' FROM tags t LEFT JOIN garments g ON g.tag_id = t.id'
             . ' GROUP BY t.id, t.text, t.color';
        $result = $mysqli->query($sql);
        $tags = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        foreach ($tags as &$tag) {
            if (isset(self::$palette[$tag['color']])) {
                [$tag['bg_color'], $tag['text_color']] = self::$palette[$tag['color']];
            } else {
                $tag['bg_color'] = '#FFFFFF';
                $tag['text_color'] = '#000000';
            }
        }
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

    public static function update(int $id, string $text, string $color): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE tags SET text = ?, color = ? WHERE id = ?');
        $stmt->bind_param('ssi', $text, $color, $id);
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

