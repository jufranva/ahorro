<?php
require_once __DIR__ . '/../../conexion.php';

class Credit
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $result = $mysqli->query('SELECT id, name, value FROM credits ORDER BY name ASC');
        $credits = $result->fetch_all(MYSQLI_ASSOC);
        $result->close();
        $mysqli->close();
        return $credits;
    }

    public static function find(int $creditId): ?array
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT id, name, value FROM credits WHERE id = ?');
        $stmt->bind_param('i', $creditId);
        $stmt->execute();
        $result = $stmt->get_result();
        $credit = $result->fetch_assoc() ?: null;
        $stmt->close();
        $mysqli->close();
        return $credit;
    }

    public static function create(string $name, float $initialValue = 0.0): int
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO credits (name, value) VALUES (?, ?)');
        $stmt->bind_param('sd', $name, $initialValue);
        $stmt->execute();
        $creditId = $stmt->insert_id;
        $stmt->close();
        $mysqli->close();
        return $creditId;
    }

    public static function addValue(int $creditId, float $amount): void
    {
        if ($amount <= 0) {
            return;
        }
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE credits SET value = value + ? WHERE id = ?');
        $stmt->bind_param('di', $amount, $creditId);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }

    public static function subtractValue(int $creditId, float $amount): void
    {
        if ($amount <= 0) {
            return;
        }
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE credits SET value = GREATEST(value - ?, 0) WHERE id = ?');
        $stmt->bind_param('di', $amount, $creditId);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }
}
