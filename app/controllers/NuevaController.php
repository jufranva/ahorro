<?php
require_once __DIR__ . '/../models/Garment.php';

class NuevaController
{
    public function index(): void
    {
        $garments = array_values(array_filter(Garment::all(), function ($g) {
            return ($g['type'] ?? '') === 'nueva';
        }));
        $total = count($garments);
        include __DIR__ . '/../views/nueva.php';
    }
}
