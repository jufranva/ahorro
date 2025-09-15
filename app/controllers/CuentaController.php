<?php
require_once __DIR__ . '/../models/Garment.php';
require_once __DIR__ . '/../models/Provider.php';

class CuentaController
{
    public function index(): void
    {
        $from = filter_input(INPUT_GET, 'from', FILTER_SANITIZE_STRING);
        $to = filter_input(INPUT_GET, 'to', FILTER_SANITIZE_STRING);
        $providerIdRaw = filter_input(INPUT_GET, 'provider_id', FILTER_SANITIZE_NUMBER_INT);
        $providerId = $providerIdRaw !== null && $providerIdRaw !== '' ? (int)$providerIdRaw : null;

        $garments = Garment::sold($from, $to, $providerId);

        $total = 0;
        foreach ($garments as $g) {
            $total += (float)$g['sale_value'];
        }

        $providers = Provider::all();
        $selectedProvider = $providerId;
        $selectedFrom = $from ?? '';
        $selectedTo = $to ?? '';

        include __DIR__ . '/../views/cuentas.php';
    }
}
