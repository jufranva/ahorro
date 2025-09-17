<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Credit.php';
require_once __DIR__ . '/../models/CreditContribution.php';

class PedidoController
{
    public function index(): void
    {
        $status = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_STRING);
        $statusFilter = in_array($status, ['pending', 'confirmed', 'credit', 'paid', 'delivered', 'rejected'], true) ? $status : null;
        $orders = Order::all($statusFilter);
        $ordersTotal = 0;
        foreach ($orders as $index => $order) {
            $items = Order::items((int)$order['id']);
            $orders[$index]['items'] = $items;
            $total = 0;
            foreach ($items as $item) {
                $total += (float)$item['sale_value'] * (int)$item['quantity'];
            }
            $orders[$index]['total'] = $total;
            $ordersTotal += $total;

            $contributions = [];
            $contributedTotal = 0.0;
            if (!empty($order['credit_id'])) {
                $contributions = CreditContribution::allByOrder((int)$order['id']);
                foreach ($contributions as $contribution) {
                    $contributedTotal += (float)$contribution['amount'];
                }
            }
            $orders[$index]['contributions'] = $contributions;
            $orders[$index]['contributed_total'] = $contributedTotal;
            $orders[$index]['outstanding'] = max($total - $contributedTotal, 0.0);
        }
        $currentStatus = $statusFilter ?? '';
        $credits = Credit::all();
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

    public function credit(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $creditIdRaw = filter_input(INPUT_POST, 'credit_id', FILTER_SANITIZE_NUMBER_INT);
        $creditNameRaw = filter_input(INPUT_POST, 'credit_name', FILTER_SANITIZE_STRING);

        $orderId = (int)$idRaw;
        $creditId = $creditIdRaw !== null && $creditIdRaw !== '' ? (int)$creditIdRaw : null;
        $creditName = $creditNameRaw !== null ? trim($creditNameRaw) : '';

        if ($orderId > 0) {
            $order = Order::find($orderId);
            if ($order && $order['status'] === 'confirmed') {
                if ($creditName !== '') {
                    $creditId = Credit::create($creditName);
                }
                if ($creditId !== null && $creditId > 0) {
                    $total = Order::total($orderId);
                    Credit::addValue($creditId, $total);
                    Order::credit($orderId, $creditId);
                }
            }
        }

        header('Location: ' . asset('pedidos.php'), true, 302);
        exit;
    }

    public function contribute(): void
    {
        $orderIdRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $orderId = (int)$orderIdRaw;

        $amountInput = $_POST['amount'] ?? '';
        $dateInput = $_POST['contributed_at'] ?? '';

        $amount = 0.0;
        if (is_string($amountInput)) {
            $cleaned = preg_replace('/[^0-9.,-]/', '', $amountInput);
            if ($cleaned !== null) {
                if (strpos($cleaned, ',') !== false && strpos($cleaned, '.') !== false) {
                    $cleaned = str_replace('.', '', $cleaned);
                }
                $normalized = str_replace(',', '.', $cleaned);
                $amount = (float)$normalized;
            }
        }
        $amount = round(max($amount, 0.0), 2);

        $date = null;
        if (is_string($dateInput)) {
            $trimmedDate = trim($dateInput);
            if ($trimmedDate !== '') {
                $timestamp = strtotime($trimmedDate);
                if ($timestamp !== false) {
                    $date = date('Y-m-d H:i:s', $timestamp);
                }
            }
        }

        if ($orderId > 0 && $amount > 0) {
            $order = Order::find($orderId);
            if ($order && $order['status'] === 'credit' && !empty($order['credit_id'])) {
                $total = Order::total($orderId);
                $contributed = CreditContribution::sumByOrder($orderId);
                $outstanding = max(round($total - $contributed, 2), 0.0);

                if ($outstanding > 0) {
                    if ($amount > $outstanding) {
                        $amount = $outstanding;
                    }
                    $amount = round($amount, 2);
                    if ($amount > 0) {
                        CreditContribution::create((int)$order['credit_id'], $orderId, $amount, $date);
                        $contributed = CreditContribution::sumByOrder($orderId);
                        if ($contributed + 0.009 >= $total) {
                            Order::pay($orderId);
                        }
                    }
                }
            }
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

    public function toggleDelivered(): void
    {
        $idRaw = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $deliveredRaw = filter_input(
            INPUT_POST,
            'entregado',
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 0, 'max_range' => 1]]
        );

        $id = (int)$idRaw;
        $delivered = null;
        if ($deliveredRaw !== null && $deliveredRaw !== false) {
            $delivered = (int)$deliveredRaw === 1;
        }

        if ($id > 0 && $delivered !== null) {
            Order::setDelivered($id, $delivered);
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
