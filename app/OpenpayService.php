<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\Log;

class OpenpayService
{
    protected $merchantId;
    protected $privateKey;
    protected $publicKey;
    protected $isSandbox;
    protected $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('services.openpay.merchant_id', env('OPENPAY_MERCHANT_ID'));
        $this->privateKey = config('services.openpay.private_key', env('OPENPAY_PRIVATE_KEY'));
        $this->publicKey = config('services.openpay.public_key', env('OPENPAY_PUBLIC_KEY'));
        $this->isSandbox = (bool) config('services.openpay.sandbox', env('OPENPAY_SANDBOX', true));

        $this->baseUrl = $this->isSandbox
            ? 'https://sandbox-api.openpay.mx/v1/'
            : 'https://api.openpay.mx/v1/';
    }

    /**
     * Crea un Checkout alojado en Openpay para que el cliente pague de forma segura.
     *
     * @param array $params
     * @return array
     */
    public function createCheckout(array $params)
    {
        $endpoint = $this->baseUrl . $this->merchantId . '/checkouts';

        // Dividir nombre y apellido si viene junto
        $nombreCompleto = trim($params['cliente_nombre'] ?? 'Cliente');
        $partesNombre = explode(' ', $nombreCompleto, 2);
        $name = $partesNombre[0];
        $lastName = isset($partesNombre[1]) && !empty($partesNombre[1]) ? $partesNombre[1] : 'S/A';

        // Limpiar teléfono (solo números, máx 10 dígitos)
        $telefono = preg_replace('/[^0-9]/', '', $params['cliente_telefono'] ?? '');
        if (strlen($telefono) > 10) {
            $telefono = substr($telefono, -10);
        }
        if (strlen($telefono) < 10) {
            $telefono = str_pad($telefono, 10, '0', STR_PAD_RIGHT);
        }

        $email = (!empty($params['cliente_email']) && !empty(trim($params['cliente_email']))) ? trim($params['cliente_email']) : 'contacto@andamiosligeros.com';

        $payload = [
            'amount' => round((float) $params['monto'], 2),
            'currency' => 'MXN',
            'description' => substr($params['descripcion'] ?? 'Compra en Tienda Andamios Ligeros', 0, 250),
            'order_id' => (string) ($params['order_id'] ?? ('AL-' . time())),
            'redirect_url' => $params['redirect_url'],
            'send_email' => false,
            'customer' => [
                'name' => $name,
                'last_name' => $lastName,
                'email' => $email,
                'phone_number' => $telefono,
            ],
        ];

        $response = $this->makeRequest('POST', $endpoint, $payload);

        return $response;
    }

    /**
     * Crea un cargo directo con tarjeta tokenizada mediante openpay.js.
     *
     * @param array $params
     * @return array
     */
    public function createCardCharge(array $params)
    {
        $endpoint = $this->baseUrl . $this->merchantId . '/charges';

        $nombreCompleto = trim($params['cliente_nombre'] ?? 'Cliente');
        $partesNombre = explode(' ', $nombreCompleto, 2);
        $name = $partesNombre[0];
        $lastName = isset($partesNombre[1]) && !empty($partesNombre[1]) ? $partesNombre[1] : 'S/A';

        $telefono = preg_replace('/[^0-9]/', '', $params['cliente_telefono'] ?? '');
        if (strlen($telefono) > 10) {
            $telefono = substr($telefono, -10);
        }
        if (strlen($telefono) < 10) {
            $telefono = str_pad($telefono, 10, '0', STR_PAD_RIGHT);
        }

        $use3DS = (bool) config('services.openpay.use_3d_secure', false);

        $email = (!empty($params['cliente_email']) && !empty(trim($params['cliente_email']))) ? trim($params['cliente_email']) : 'contacto@andamiosligeros.com';

        $payload = [
            'source_id' => $params['token_id'],
            'method' => 'card',
            'amount' => round((float) $params['monto'], 2),
            'currency' => 'MXN',
            'description' => substr($params['descripcion'] ?? 'Compra en Tienda Andamios Ligeros', 0, 250),
            'order_id' => (string) ($params['order_id'] ?? ('AL-' . time())),
            'device_session_id' => $params['device_session_id'] ?? '',
            'customer' => [
                'name' => $name,
                'last_name' => $lastName,
                'email' => $email,
                'phone_number' => $telefono,
            ],
        ];

        if ($use3DS) {
            $payload['use_3d_secure'] = true;
            if (!empty($params['redirect_url'])) {
                $payload['redirect_url'] = $params['redirect_url'];
            }
        }

        return $this->makeRequest('POST', $endpoint, $payload);
    }

    /**
     * Consulta el estado de una transacción o cargo.
     *
     * @param string $chargeId
     * @return array
     */
    public function getCharge($chargeId)
    {
        $endpoint = $this->baseUrl . $this->merchantId . '/charges/' . $chargeId;
        return $this->makeRequest('GET', $endpoint);
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function isSandbox()
    {
        return $this->isSandbox;
    }


    /**
     * Ejecuta la petición cURL a la API de Openpay con autenticación HTTP Basic.
     *
     * @param string $method
     * @param string $url
     * @param array|null $data
     * @return array
     */
    protected function makeRequest($method, $url, $data = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->privateKey . ':');
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif (strtoupper($method) === 'GET') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }

        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($curlError) {
            Log::error('Openpay Service cURL Error: ' . $curlError . ' URL: ' . $url);
            return [
                'success' => false,
                'error_code' => 'curl_error',
                'description' => 'No fue posible conectarse con el servidor de pagos de Openpay.'
            ];
        }

        $jsonResponse = json_decode($rawResponse, true);

        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'data' => $jsonResponse
            ];
        }

        Log::error("Openpay Error [HTTP {$httpCode}]:", [
            'url' => $url,
            'response' => $jsonResponse
        ]);

        $errorMessage = $jsonResponse['description'] ?? 'Error desconocido al procesar con Openpay.';
        return [
            'success' => false,
            'http_code' => $httpCode,
            'error_code' => $jsonResponse['error_code'] ?? null,
            'description' => $errorMessage,
            'raw' => $jsonResponse
        ];
    }
}
