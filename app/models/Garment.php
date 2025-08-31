<?php
require_once __DIR__ . '/../../conexion.php';
require_once __DIR__ . '/Tag.php';

class Garment
{
    public static function all(): array
    {
        $mysqli = obtenerConexion();
        $sql = 'SELECT g.*, c.name AS category_name, p.name AS provider_name, t.text AS tag_text, t.color AS tag_color, s.name AS state_name '
             . 'FROM garments g '
             . 'LEFT JOIN categories c ON g.category_id = c.id '
             . 'LEFT JOIN providers p ON g.provider_id = p.id '
             . 'LEFT JOIN tags t ON g.tag_id = t.id '
             . 'LEFT JOIN states s ON g.state_id = s.id';
        $result = $mysqli->query($sql);
        $garments = $result->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        $palette = Tag::palette();
        foreach ($garments as &$garment) {
            if (!empty($garment['tag_color']) && isset($palette[$garment['tag_color']])) {
                [$garment['tag_bg_color'], $garment['tag_text_color']] = $palette[$garment['tag_color']];
            } else {
                $garment['tag_bg_color'] = null;
                $garment['tag_text_color'] = null;
            }
        }
        return $garments;
    }

    public static function create(string $name, string $imagePrimary, ?string $imageSecondary, float $purchase, float $sale, int $condition, string $size, string $comment, string $type, ?int $category, ?int $provider, ?int $tag, ?int $state, ?string $purchaseDate): bool
    {
        $mysqli = obtenerConexion();
        $code = '';
        $purchaseDate = $purchaseDate ?? date('Y-m-d');
        $saleDate = null;
        if ($imageSecondary === '') {
            $imageSecondary = null;
        }
        $stmt = $mysqli->prepare('INSERT INTO garments (name, image_primary, image_secondary, purchase_value, sale_value, unique_code, `condition`, size, comment, type, category_id, provider_id, tag_id, state_id, purchase_date, sale_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssddsisssiiiiss', $name, $imagePrimary, $imageSecondary, $purchase, $sale, $code, $condition, $size, $comment, $type, $category, $provider, $tag, $state, $purchaseDate, $saleDate);
        $success = $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();

        if ($success) {
            $prefix = '';
            if ($provider !== null) {
                $provStmt = $mysqli->prepare('SELECT name FROM providers WHERE id=?');
                $provStmt->bind_param('i', $provider);
                $provStmt->execute();
                $provStmt->bind_result($provName);
                if ($provStmt->fetch()) {
                    $prefix = strtoupper(substr($provName, 0, 2));
                }
                $provStmt->close();
            }
            $typeCode = $type === 'usada' ? 'US' : 'NU';
            $code = $prefix . $typeCode . '00' . $id;
            $upd = $mysqli->prepare('UPDATE garments SET unique_code=? WHERE id=?');
            $upd->bind_param('si', $code, $id);
            $upd->execute();
            $upd->close();
        }

        $mysqli->close();
        return $success;
    }

    public static function update(int $id, string $name, string $imagePrimary, ?string $imageSecondary, float $purchase, float $sale, string $code, int $condition, string $size, string $comment, string $type, ?int $category, ?int $provider, ?int $tag, ?int $state, ?string $purchaseDate): bool
    {
        $mysqli = obtenerConexion();
        if ($imageSecondary === '') {
            $imageSecondary = null;
        }
        $stmt = $mysqli->prepare('UPDATE garments SET name=?, image_primary=?, image_secondary=?, purchase_value=?, sale_value=?, unique_code=?, `condition`=?, size=?, comment=?, type=?, category_id=?, provider_id=?, tag_id=?, state_id=?, purchase_date=? WHERE id=?');
        $stmt->bind_param('sssddsisssiiiisi', $name, $imagePrimary, $imageSecondary, $purchase, $sale, $code, $condition, $size, $comment, $type, $category, $provider, $tag, $state, $purchaseDate, $id);
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

    public static function updateState(int $id, ?int $stateId): bool
    {
        $mysqli = obtenerConexion();
        if ($stateId === null) {
            $stmt = $mysqli->prepare('UPDATE garments SET state_id=NULL, sale_date=NULL WHERE id=?');
            $stmt->bind_param('i', $id);
        } else {
            $nameStmt = $mysqli->prepare('SELECT name FROM states WHERE id=?');
            $nameStmt->bind_param('i', $stateId);
            $nameStmt->execute();
            $nameStmt->bind_result($stateName);
            $nameStmt->fetch();
            $nameStmt->close();

            if (strtolower($stateName) === 'vendido') {
                $stmt = $mysqli->prepare('UPDATE garments SET state_id=?, sale_date=CURDATE() WHERE id=?');
                $stmt->bind_param('ii', $stateId, $id);
            } else {
                $stmt = $mysqli->prepare('UPDATE garments SET state_id=?, sale_date=NULL WHERE id=?');
                $stmt->bind_param('ii', $stateId, $id);
            }
        }
        $success = $stmt->execute();
        $stmt->close();
        $mysqli->close();
        return $success;
    }
}
?>
