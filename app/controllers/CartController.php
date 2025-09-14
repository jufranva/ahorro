<?php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Garment.php';
require_once __DIR__ . '/../services/WhatsAppNotifier.php';

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
        $garment = null;
        if ($id > 0) {
            Cart::add($id, $quantity);
            $garment = Garment::find($id);
        }
        $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';
        if ($isAjax) {
            header('Content-Type: application/json');
            $data = ['success' => true];
            if ($garment) {
                $data['garment'] = [
                    'name' => $garment['name'] ?? '',
                    'comment' => $garment['comment'] ?? '',
                    'price' => number_format((float)($garment['sale_value'] ?? 0), 2),
                    'image' => asset($garment['image_primary'] ?? '')
                ];
            }
            echo json_encode($data);
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
            $orderId = Order::create($name, $phone, $payment, $items);
            WhatsAppNotifier::sendNewOrderNotification($orderId);
            Cart::clear(false);
            foreach ($items as $item) {
                Garment::markReserved((int)$item['garment_id']);
            }
        }
        header('Location: ' . asset('index.php'), true, 302);
        exit;
    }
}
