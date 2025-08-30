<?php
require_once __DIR__ . '/../../conexion.php';

class State
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, name FROM states');
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
}
?>
