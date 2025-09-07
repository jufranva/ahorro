<?php
require_once __DIR__ . '/../models/Garment.php';
require_once __DIR__ . '/../models/Category.php';

class UsadaController
{
    public function index(): void
    {
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $sort = $_GET['sort'] ?? null;
        $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 9;
        $allowedPerPage = [9, 15, 24, 36, 51];
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 9;
        }
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        $garments = array_values(array_filter(Garment::all(null, null, $categoryId, null, $sort), function ($g) {
            return ($g['type'] ?? '') === 'usada';
        }));
        $total = count($garments);
        $pages = (int)ceil($total / $perPage);
        if ($page > $pages && $pages > 0) {
            $page = $pages;
        }
        $garments = array_slice($garments, ($page - 1) * $perPage, $perPage);

        $categories = array_values(
            array_filter(
                Category::all('usada'),
                static function ($cat) {
                    return (int)($cat['usage_count'] ?? 0) > 0;
                }
            )
        );
        include __DIR__ . '/../views/usada.php';
    }
}
