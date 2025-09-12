<?php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Garment.php';

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
        $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
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

    public function checkout(): void
    {
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
        $payment = filter_input(INPUT_POST, 'payment', FILTER_SANITIZE_STRING);
        $items = Cart::items();
        if ($name !== '' && $phone !== '' && $payment && !empty($items)) {
            Order::create($name, $phone, $payment, $items);
            Cart::clear(false);
            foreach ($items as $item) {
                Garment::markReserved((int)$item['garment_id']);
            }
        }
        header('Location: ' . asset('index.php'), true, 302);
        exit;
    }
}
