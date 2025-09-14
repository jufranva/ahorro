<?php
require_once __DIR__ . '/../models/Order.php';

class PedidoController
{
    public function index(): void
    {
        $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
        $statusFilter = in_array($status, ['pending', 'confirmed', 'paid', 'delivered', 'rejected'], true) ? $status : null;
        $orders = Order::all($statusFilter);
        foreach ($orders as $index => $order) {
            $items = Order::items((int)$order['id']);
            $orders[$index]['items'] = $items;
            $total = 0;
            foreach ($items as $item) {
                $total += (float)$item['sale_value'] * (int)$item['quantity'];
            }
            $orders[$index]['total'] = $total;
        }
        $currentStatus = $statusFilter ?? '';
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

    public function pay(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        if ($id > 0) {
            Order::pay($id);
        }
        header('Location: ' . asset('pedidos.php'), true, 302);
        exit;
    }

    public function deliver(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        if ($id > 0) {
            Order::deliver($id);
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

    public function delete(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $id = (int)$idRaw;
        if ($id > 0) {
            Order::delete($id);
        }
        header('Location: ' . asset('pedidos.php'), true, 302);
        exit;
    }
}
