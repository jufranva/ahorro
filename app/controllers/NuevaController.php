<?php
require_once __DIR__ . '/../models/Garment.php';
require_once __DIR__ . '/../models/Category.php';

class NuevaController
{
    public function index(): void
    {
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $garments = array_values(array_filter(Garment::all(null, null, $categoryId), function ($g) {
            return ($g['type'] ?? '') === 'nueva';
        }));
        $total = count($garments);
        $categories = Category::all();
        include __DIR__ . '/../views/nueva.php';
    }
}
