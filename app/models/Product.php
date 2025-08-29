<?php
class Product
{
    public static function all(): array
    {
        return [
            ['title' => 'Basic Jogging Shorts', 'price' => 14.50, 'old_price' => 18.00],
            ['title' => 'Brother Hoddies in Grey', 'price' => 38.50, 'old_price' => 42.85],
        ];
    }
}
