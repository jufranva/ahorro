<?php
require_once __DIR__ . '/../../conexion.php';

class Garment
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT g.*, c.name AS category_name, t.text AS tag_text, t.bg_color AS tag_bg_color, t.text_color AS tag_text_color, s.name AS state_name '
             . 'FROM garments g '
             . 'LEFT JOIN categories c ON g.category_id = c.id '
             . 'LEFT JOIN tags t ON g.tag_id = t.id '
             . 'LEFT JOIN states s ON g.state_id = s.id';
        $result = $mysqli->query($sql);
        $garments = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $garments;
    }

    public static function create(string $name, string $imagePrimary, string $imageSecondary, float $purchase, float $sale, string $code, int $condition, string $size, string $comment, string $type, ?int $category, ?int $tag, ?int $state, ?string $purchaseDate, ?string $saleDate): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('INSERT INTO garments (name, image_primary, image_secondary, purchase_value, sale_value, unique_code, `condition`, size, comment, type, category_id, tag_id, state_id, purchase_date, sale_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssddsisssiiiss', $name, $imagePrimary, $imageSecondary, $purchase, $sale, $code, $condition, $size, $comment, $type, $category, $tag, $state, $purchaseDate, $saleDate);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $name, string $imagePrimary, string $imageSecondary, float $purchase, float $sale, string $code, int $condition, string $size, string $comment, string $type, ?int $category, ?int $tag, ?int $state, ?string $purchaseDate, ?string $saleDate): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('UPDATE garments SET name=?, image_primary=?, image_secondary=?, purchase_value=?, sale_value=?, unique_code=?, `condition`=?, size=?, comment=?, type=?, category_id=?, tag_id=?, state_id=?, purchase_date=?, sale_date=? WHERE id=?');
        $stmt->bind_param('sssddsisssiiissi', $name, $imagePrimary, $imageSecondary, $purchase, $sale, $code, $condition, $size, $comment, $type, $category, $tag, $state, $purchaseDate, $saleDate, $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }

    public static function delete(int $id): bool
    {
        $mysqli = obtenerConexion();
        $stmt = $mysqli->prepare('DELETE FROM garments WHERE id=?');
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
