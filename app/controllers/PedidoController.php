<?php
require_once __DIR__ . '/../models/Order.php';

class PedidoController
{
    public function index(): void
    {
        $orders = Order::all();
        foreach ($orders as $index => $order) {
            $orders[$index]['items'] = Order::items((int)$order['id']);
        }
        include __DIR__ . '/../views/pedidos.php';
    }

    public function confirm(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        if ($id > 0) {
            Order::confirm($id);
        }
        header('Location: ' . asset('pedidos.php'), true, 302);
        exit;
    }

    public function reject(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        if ($id > 0) {
            Order::reject($id);
        }
        header('Location: ' . asset('pedidos.php'), true, 302);
        exit;
    }
}
