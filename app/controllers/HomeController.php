<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Slide.php';
require_once __DIR__ . '/../models/Banner.php';

class HomeController
{
    public function index(): void
    {
        $products = Product::all();
        $slides = Slide::all();
        $banners = Banner::all();
        include __DIR__ . '/../views/home.php';
    }
}
