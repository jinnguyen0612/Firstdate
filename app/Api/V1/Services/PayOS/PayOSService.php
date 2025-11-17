<?php

namespace App\Api\V1\Services\PayOS;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PayOS\Utils\PayOSSignatureUtils;

class PayOSService
{
    private string $clientId;
    private string $apiKey;
    private string $checksumKey;
    /**
     * Base URL PayOS (v2)
     */
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('PAYOS_BASE_URL', 'https://api-merchant.payos.vn');
        $this->clientId = env('PAYOS_CLIENT_ID');
        $this->apiKey = env('PAYOS_API_KEY');
        $this->checksumKey = env('PAYOS_CHECKSUM_KEY');
    }

    /**
     * Tạo yêu cầu thanh toán (Payment Request)
     */
    public function createPayment(string $orderCode, float $amount, string $description): array
    {
        $returnUrl = env('APP_URL') . '/api/v1/payos/webhook'; // link client web/app sẽ nhận khi thanh toán xong
        $cancelUrl = env('APP_URL') . '/api/v1/transactions/cancel'; // link khi người dùng hủy thanh toán

        $paymentData = [
            'orderCode'   => (int)$orderCode,
            'amount'      => (int) $amount,
            'description' => $description,
            'returnUrl'   => $returnUrl,
            'cancelUrl'   => $cancelUrl,
            'expiredAt'   => now()->addMinutes(15)->timestamp,
        ];
        Log::info('PayOS createPayment data', $paymentData);

        // Kiểm tra dữ liệu đầu vào
        foreach ($paymentData as $key => $value) {
            if (empty($value)) {
                Log::error("Thiếu trường dữ liệu: {$key}");
                throw new \Exception("Thiếu trường dữ liệu: {$key}");
            }
        }

        $url = $this->baseUrl . '/v2/payment-requests';

        // Tạo chữ ký theo quy định PayOS
        $signature = PayOSSignatureUtils::createSignatureOfPaymentRequest(
            $this->checksumKey,
            $paymentData
        );

        $headers = [
            'x-client-id: ' . $this->clientId,
            'x-api-key: ' . $this->apiKey,
            'Content-Type: application/json'
        ];

        $payload = array_merge($paymentData, ['signature' => $signature]);

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_TIMEOUT => 30,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($response === false) {
                throw new \Exception('Không thể kết nối tới PayOS API.');
            }

            $result = json_decode($response, true);
            Log::info('PayOS createPayment response', $result);

            // Kiểm tra lỗi HTTP hoặc lỗi trả về từ API
            if ($httpCode !== 200 || !isset($result['code'])) {
                Log::error('Phản hồi PayOS không hợp lệ', ['response' => $response]);
                throw new \Exception('Phản hồi PayOS không hợp lệ.');
            }

            if ($result['code'] !== '00') {
                throw new \Exception($result['desc'] ?? 'Lỗi từ PayOS API', (int)$result['code']);
            }

            // Xác minh chữ ký phản hồi
            $data = $result['data'] ?? [];
            $resSignature = PayOSSignatureUtils::createSignatureFromObj($this->checksumKey, $data);

            if ($resSignature !== ($result['signature'] ?? '')) {
                throw new \Exception('Dữ liệu trả về không toàn vẹn (signature mismatch)');
            }

            // ✅ Trả về data gốc từ PayOS (bao gồm URL thanh toán, QR code, ...)
            return $data;
        } catch (\Exception $e) {
            Log::error('PayOS createPayment failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Thanh toán thất bại: ' . $e->getMessage());
        }
    }


    /**
     * Lấy trạng thái thanh toán (query status)
     */
    public function getPaymentStatus(string $orderCode): ?string
    {
        $headers = [
            'x-client-id' => env('PAYOS_CLIENT_ID'),
            'x-api-key'   => env('PAYOS_API_KEY'),
        ];

        $url = $this->baseUrl . '/' . $orderCode;
        $response = Http::withHeaders($headers)->get($url);

        if ($response->failed()) {
            Log::error('PayOS getPaymentStatus failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        return $response->json('data.status');
    }
}
