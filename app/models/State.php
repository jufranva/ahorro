<?php
require_once __DIR__ . '/../../conexion.php';

class State
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT s.id, s.name, COUNT(g.id) AS usage_count
                FROM states s LEFT JOIN garments g ON g.state_id = s.id
                GROUP BY s.id, s.name';
        $result = $mysqli->query($sql);
        $states = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $states;
    }

    public static function create(string $name): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO states (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $name): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE states SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $check = $mysqli->prepare('SELECT COUNT(*) FROM garments WHERE state_id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();
        if ($count > 0) {
            $mysqli->close();
            return false;
        }
        $stmt = $mysqli->prepare('DELETE FROM states WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
