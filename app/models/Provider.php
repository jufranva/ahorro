<?php
require_once __DIR__ . '/../../conexion.php';

class Provider
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT p.id, p.name, COUNT(g.id) AS usage_count '
             . 'FROM providers p LEFT JOIN garments g ON g.provider_id = p.id '
             . 'GROUP BY p.id, p.name';
        $result = $mysqli->query($sql);
        $providers = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $providers;
    }

    public static function create(string $name): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO providers (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $name): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE providers SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $name, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $check = $mysqli->prepare('SELECT COUNT(*) FROM garments WHERE provider_id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $check->bind_result($count);
        $check->fetch();
        $check->close();
        if ($count > 0) {
            $mysqli->close();
            return false;
        }
        $stmt = $mysqli->prepare('DELETE FROM providers WHERE id = ?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
