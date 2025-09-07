<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/Garment.php';

class Cart
{
    private static function getSessionId(): string
    {
        if (empty($_SESSION['cart_session'])) {
            $_SESSION['cart_session'] = bin2hex(random_bytes(16));
        }
        return $_SESSION['cart_session'];
    }

    public static function add(int $garmentId, int $quantity = 1): bool
    {
        $sessionId = self::getSessionId();
        $quantity = max(1, $quantity);
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO cart_items (session_id, garment_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)');
        $stmt->bind_param('sii', $sessionId, $garmentId, $quantity);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        if ($success) {
            Garment::markReserved($garmentId);
        }
        return $success;
    }

    public static function items(): array
    {
        $sessionId = self::getSessionId();
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT ci.id, ci.quantity, ci.garment_id, g.name, g.sale_value, g.image_primary FROM cart_items ci JOIN garments g ON ci.garment_id = g.id WHERE ci.session_id = ?');
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $mysqli->close();
        return $items;
    }

    public static function remove(int $id): bool
    {
        $sessionId = self::getSessionId();
        $mysqli = obtenerConexion();

        $find = $mysqli->prepare('SELECT garment_id FROM cart_items WHERE id=? AND session_id=?');
        $find->bind_param('is', $id, $sessionId);
        $find->execute();
        $find->bind_result($garmentId);
        $find->fetch();
        $find->close();

        $stmt = $mysqli->prepare('DELETE FROM cart_items WHERE id=? AND session_id=?');
        $stmt->bind_param('is', $id, $sessionId);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        if ($success && $garmentId) {
            Garment::releaseReservation($garmentId);
        }
        return $success;
    }

    public static function count(): int
    {
        $sessionId = self::getSessionId();
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT COALESCE(SUM(quantity),0) FROM cart_items WHERE session_id=?');
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        $mysqli->close();
        return (int)$count;
    }

    public static function clear(bool $release = true): void
    {
        $sessionId = self::getSessionId();
        $items = $release ? self::items() : [];
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('DELETE FROM cart_items WHERE session_id=?');
        $stmt->bind_param('s', $sessionId);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
        if ($release) {
            foreach ($items as $item) {
                Garment::releaseReservation((int)$item['garment_id']);
            }
        }
    }

    public static function purgeExpired(): void
    {
        $mysqli = obtenerConexion();
        $res = $mysqli->query("SELECT id, garment_id FROM cart_items WHERE created_at < (NOW() - INTERVAL 1 HOUR)");
        if ($res) {
            $rows = $res->fetch_all(MYSQLI_ASSOC);
            $res->close();
            foreach ($rows as $row) {
                Garment::releaseReservation((int)$row['garment_id']);
                $del = $mysqli->prepare('DELETE FROM cart_items WHERE id=?');
                $id = (int)$row['id'];
                $del->bind_param('i', $id);
                $del->execute();
                $del->close();
            }
        }
        $mysqli->close();
    }
}
