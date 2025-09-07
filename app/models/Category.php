<?php
require_once __DIR__ . '/../../conexion.php';

class Category
{
    public static function all(?string $type = null, ?int $excludeStateId = null): array
    {
        $mysqli = obtenerConexion();

        $joinConditions = ['g.category_id = c.id'];
        $types = '';
        $params = [];

        if ($type !== null) {
            $joinConditions[] = 'g.type = ?';
            $types .= 's';
            $params[] = &$type;
        }
        if ($excludeStateId !== null) {
            $joinConditions[] = '(g.state_id IS NULL OR g.state_id != ?)';
            $types .= 'i';
            $params[] = &$excludeStateId;
        }

        $sql = 'SELECT c.id, c.name, COUNT(g.id) AS usage_count '
            . 'FROM categories c LEFT JOIN garments g ON ' . implode(' AND ', $joinConditions)
            . ' GROUP BY c.id, c.name';

        if (!empty($params)) {
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $categories = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            $result = $mysqli->query($sql);
            $categories = $result->fetch_all(MYSQLI_ASSOC);
        }

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

