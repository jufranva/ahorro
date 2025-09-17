<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/Credit.php';

class CreditContribution
{
    public static function create(int $creditId, int $orderId, float $amount, ?string $date = null): int
    {
        if ($amount <= 0) {
            return 0;
        }

        $mysqli = obtenerConexion();
        if ($date !== null && $date !== '') {
            $stmt = $mysqli->prepare('INSERT INTO credit_contributions (credit_id, order_id, amount, contributed_at) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('iids', $creditId, $orderId, $amount, $date);
        } else {
            $stmt = $mysqli->prepare('INSERT INTO credit_contributions (credit_id, order_id, amount) VALUES (?, ?, ?)');
            $stmt->bind_param('iid', $creditId, $orderId, $amount);
        }
        $stmt->execute();
        $contributionId = $stmt->insert_id;
        $stmt->close();
        $mysqli->close();

        Credit::subtractValue($creditId, $amount);

        return $contributionId;
    }

    public static function allByCredit(int $creditId): array
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT id, credit_id, order_id, amount, contributed_at FROM credit_contributions WHERE credit_id = ? ORDER BY contributed_at DESC');
        $stmt->bind_param('i', $creditId);
        $stmt->execute();
        $result = $stmt->get_result();
        $contributions = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $mysqli->close();

        return $contributions;
    }

    public static function allByOrder(int $orderId): array
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT id, credit_id, order_id, amount, contributed_at FROM credit_contributions WHERE order_id = ? ORDER BY contributed_at DESC');
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $contributions = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $mysqli->close();

        return $contributions;
    }

    public static function sumByOrder(int $orderId): float
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT COALESCE(SUM(amount), 0) AS total FROM credit_contributions WHERE order_id = ?');
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        $mysqli->close();

        return isset($row['total']) ? (float)$row['total'] : 0.0;
    }
}
