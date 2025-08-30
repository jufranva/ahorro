<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Slide.php';

class HomeController
{
    public function index(): void
    {
        $products = Product::all();
        $slides = Slide::all();
        include __DIR__ . '/../views/home.php';
    }
}
