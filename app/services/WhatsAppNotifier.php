<?php
class WhatsAppNotifier
{
    private const RECIPIENT = 'whatsapp:+593999591820';

    public static function sendNewOrderNotification(int $orderId): void
    {
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_TOKEN');
        $from = getenv('TWILIO_WHATSAPP_FROM');

        if (!$sid || !$token || !$from) {
            return;
        }

        $message = "Nueva venta realizada. Pedido #{$orderId}";
        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

        $data = http_build_query([
            'From' => $from,
            'To'   => self::RECIPIENT,
            'Body' => $message,
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_USERPWD, $sid . ':' . $token);
        curl_exec($ch);
        curl_close($ch);
    }
}
