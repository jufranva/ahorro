<?php
require_once __DIR__ . '/../models/Cart.php';

class CartController
{
    public function index(): void
    {
        $items = Cart::items();
        include __DIR__ . '/../views/cart.php';
    }

    public function add(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $qtyRaw = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        $quantity = $qtyRaw !== null ? (int)$qtyRaw : 1;
        if ($id > 0) {
            Cart::add($id, $quantity);
        }
        header('Location: ' . asset('cart.php'), true, 302);
        exit;
    }

    public function remove(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        if ($id > 0) {
            Cart::remove($id);
        }
        header('Location: ' . asset('cart.php'), true, 302);
        exit;
    }
}
