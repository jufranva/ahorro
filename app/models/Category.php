<?php
require_once __DIR__ . '/../../conexion.php';

class Category
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT c.id, c.name, COUNT(g.id) AS usage_count
                FROM categories c LEFT JOIN garments g ON g.category_id = c.id
                GROUP BY c.id, c.name';
        $result = $mysqli->query($sql);
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

    public static function update(int $id, string $name): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $check = $mysqli->prepare('SELECT COUNT(*) FROM garments WHERE category_id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();
        if ($count > 0) {
            $mysqli->close();
            return false;
        }
        $stmt = $mysqli->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
