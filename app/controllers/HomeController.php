<?php
require_once __DIR__ . '/../models/Product.php';

class HomeController
{
    public function index(): void
    {
        $products = Product::all();
        include __DIR__ . '/../views/home.php';
    }
}
