<?php
require_once __DIR__ . '/../models/Slide.php';
require_once __DIR__ . '/../models/Banner.php';
require_once __DIR__ . '/../models/Feature.php';
require_once __DIR__ . '/../models/Garment.php';
require_once __DIR__ . '/../models/State.php';

class HomeController
{
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $slides = Slide::all();
        $banners = Banner::all();
        $features = Feature::all();

        $stateId = State::getIdByName('Recien llegado');
        $garments = $stateId === null ? [] : Garment::all(null, $stateId, null, 'new');
        $newArrivals = array_values(array_filter($garments, function ($g) {
            return ($g['type'] ?? '') === 'nueva';
        }));
        $usedArrivals = array_values(array_filter($garments, function ($g) {
            return ($g['type'] ?? '') === 'usada';
        }));

        include __DIR__ . '/../views/home.php';
    }
}
