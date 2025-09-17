<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/Garment.php';

class Order
{
    public static function create(string $name, string $phone, string $payment, array $items): int
    {
        $mysqli = obtenerConexion();
        $mysqli->begin_transaction();
        $stmt = $mysqli->prepare('INSERT INTO orders (buyer_name, phone, payment_method) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $phone, $payment);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        $stmt->close();

        $itemStmt = $mysqli->prepare('INSERT INTO order_items (order_id, garment_id, quantity) VALUES (?, ?, ?)');
        foreach ($items as $item) {
            $garmentId = (int)$item['garment_id'];
            $qty = (int)$item['quantity'];
            $itemStmt->bind_param('iii', $orderId, $garmentId, $qty);
            $itemStmt->execute();
        }
        $itemStmt->close();
        $mysqli->commit();
        $mysqli->close();

        return $orderId;
    }

    public static function all(?string $status = null): array
    {
        $mysqli = obtenerConexion();
        $baseSql = 'SELECT o.id, o.buyer_name, o.phone, o.payment_method, o.status, o.entregado, o.credit_id, c.name AS credit_name, c.value AS credit_value '
                 . 'FROM orders o '
                 . 'LEFT JOIN credits c ON o.credit_id = c.id';

        if ($status && in_array($status, ['pending', 'confirmed', 'credit', 'paid', 'delivered', 'rejected'], true)) {
            $stmt = $mysqli->prepare($baseSql . ' WHERE o.status = ? ORDER BY o.id DESC');
            $stmt->bind_param('s', $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
        } else {
            $result = $mysqli->query($baseSql . ' ORDER BY o.id DESC');
            $orders = $result->fetch_all(MYSQLI_ASSOC);
            $result->close();
        }
        $mysqli->close();
        return $orders;
    }

    public static function items(int $orderId): array
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT oi.garment_id, oi.quantity, g.name, g.unique_code, g.image_primary, g.sale_value FROM order_items oi JOIN garments g ON oi.garment_id = g.id WHERE oi.order_id = ?');
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $mysqli->close();
        return $items;
    }

    public static function confirm(int $orderId): void
    {
        $items = self::items($orderId);
        foreach ($items as $item) {
            Garment::markSold((int)$item['garment_id']);
        }
        $mysqli = obtenerConexion();
        $upd = $mysqli->prepare("UPDATE orders SET status='confirmed' WHERE id=?");
        $upd->bind_param('i', $orderId);
        $upd->execute();
        $upd->close();
        $mysqli->close();
    }

    public static function reject(int $orderId): void
    {
        $items = self::items($orderId);
        foreach ($items as $item) {
            Garment::releaseReservation((int)$item['garment_id']);
        }
        $mysqli = obtenerConexion();
        $upd = $mysqli->prepare("UPDATE orders SET status='rejected' WHERE id=?");
        $upd->bind_param('i', $orderId);
        $upd->execute();
        $upd->close();
        $mysqli->close();
    }

    public static function find(int $orderId): ?array
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('SELECT id, buyer_name, phone, payment_method, status, entregado, credit_id FROM orders WHERE id = ?');
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc() ?: null;
        $stmt->close();
        $mysqli->close();
        return $order;
    }

    public static function pay(int $orderId): void
    {
        $items = self::items($orderId);
        foreach ($items as $item) {
            Garment::setSaleDate((int)$item['garment_id']);
        }
        $mysqli = obtenerConexion();
        $upd = $mysqli->prepare("UPDATE orders SET status='paid' WHERE id=?");
        $upd->bind_param('i', $orderId);
        $upd->execute();
        $upd->close();
        $mysqli->close();
    }

    public static function credit(int $orderId, int $creditId): void
    {
        $items = self::items($orderId);
        foreach ($items as $item) {
            Garment::setSaleDate((int)$item['garment_id']);
        }
        $mysqli = obtenerConexion();
        $upd = $mysqli->prepare("UPDATE orders SET status='credit', credit_id=? WHERE id=?");
        $upd->bind_param('ii', $creditId, $orderId);
        $upd->execute();
        $upd->close();
        $mysqli->close();
    }

    public static function total(int $orderId): float
    {
        $items = self::items($orderId);
        $total = 0.0;
        foreach ($items as $item) {
            $total += (float)$item['sale_value'] * (int)$item['quantity'];
        }
        return $total;
    }

    public static function deliver(int $orderId): void
    {
        $mysqli = obtenerConexion();
        $delivered = 1;
        $upd = $mysqli->prepare("UPDATE orders SET status='delivered', entregado=? WHERE id=?");
        $upd->bind_param('ii', $delivered, $orderId);
        $upd->execute();
        $upd->close();
        $mysqli->close();
    }

    public static function setDelivered(int $orderId, bool $delivered): void
    {
        $mysqli = obtenerConexion();
        $value = $delivered ? 1 : 0;
        $stmt = $mysqli->prepare('UPDATE orders SET entregado = ? WHERE id = ?');
        $stmt->bind_param('ii', $value, $orderId);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    }

    public static function delete(int $orderId): void
    {
        $mysqli = obtenerConexion();
        $del = $mysqli->prepare('DELETE FROM orders WHERE id = ?');
        $del->bind_param('i', $orderId);
        $del->execute();
        $del->close();
        $mysqli->close();
    }
}
