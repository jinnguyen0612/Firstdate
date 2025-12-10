<?php

namespace App\Api\V1\Http\Controllers\PayOS;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Api\V1\Http\Resources\Transaction\ShowTransactionResource;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Api\V1\Services\PayOS\PayOSService;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Models\PriceList;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PayOS\Utils\PayOSSignatureUtils;

class PayOSController extends Controller
{
    public function __construct(
        protected PayOSService $payOSService,
        protected TransactionRepositoryInterface $transactionRepository,
    ) {}

    public function webhook(Request $request)
    {
        try {
            Log::info('PayOS webhook received', $request->all());

            $payload = $request->all();

            // ✅ Xác minh chữ ký ĐÚNG CÁCH
            if (!$this->verifyChecksum($payload)) {
                Log::warning('PayOS webhook: invalid signature', $payload);
                return response()->json(['message' => 'Invalid signature'], 401);
            }

            $data      = $payload['data'] ?? [];
            $orderCode = $data['orderCode'] ?? null;
            $status    = $data['status'] ?? null;

            if (!$orderCode) {
                return response()->json(['message' => 'Missing orderCode'], 400);
            }

            // Lưu ý: lúc tạo payment bạn dùng orderCode = transaction->id
            $transaction = Transaction::where('id', $orderCode)->first();

            // ✅ Check null trước khi dùng
            if (!$transaction) {
                Log::warning("PayOS webhook: Transaction {$orderCode} not found");
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            $user = $transaction->from; // quan hệ from() phải tồn tại trong model Transaction

            // Cập nhật trạng thái
            if ($status === 'PAID') {
                $transaction->update([
                    'status' => TransactionStatus::Success->value,
                ]);

                // Tìm gói coin gần nhất theo amount
                $coin = PriceList::orderByRaw('ABS(price - ?)', [$transaction['amount']])->first();

                if ($coin) {
                    // Cộng ví user
                    $user->increment('wallet', $coin->value);

                    // Tạo thêm transaction "receive" cho lịch sử ví (nếu bạn cần)
                    $message = [
                        'value'   => $coin->value,
                        'service' => "việc nạp tiền hệ thống",
                    ];

                    $this->transactionRepository->createTransaction(
                        null,
                        $user,
                        $coin->value,
                        TransactionType::Receive->value,
                        TransactionStatus::Success->value,
                        null,
                        TransactionMessage::message(
                            TransactionType::Receive->value,
                            $message
                        )
                    );
                }
            } else {
                $transaction->update([
                    'status' => TransactionStatus::Failed->value,
                ]);
            }

            return response()->json(['message' => 'Webhook handled']);
        } catch (\Throwable $e) {
            Log::error('PayOS webhook error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Server error'], 500);
        }
    }

    /**
     * Verify signature từ PayOS webhook
     */
    private function verifyChecksum(array $payload): bool
    {
        $checksumKey = env('PAYOS_CHECKSUM_KEY');

        // PayOS gửi signature ở root, data nằm trong key 'data'
        $data              = $payload['data'] ?? [];
        $receivedSignature = $payload['signature'] ?? '';

        if (!$receivedSignature || empty($data)) {
            return false;
        }

        // ✅ Dùng cùng helper như lúc tạo payment
        $expectedSignature = PayOSSignatureUtils::createSignatureFromObj(
            $checksumKey,
            $data
        );

        return hash_equals($expectedSignature, $receivedSignature);
    }

    public function getPayment($orderCode)
    {
        try {
            $transaction = $this->transactionRepository
                ->getQueryBuilder()
                ->where('payos_order_code', $orderCode)
                ->first();
            if (!$transaction) {
                return response()->json([
                    'status'  => 404,
                    'message' => 'Không tìm thấy giao dịch trong hệ thống',
                ], 404);
            }

            $user = $transaction->from; // quan hệ from() trong Transaction

            if ($transaction->status != TransactionStatus::Pending->value) {
                return response()->json([
                    'status' => 200,
                    'data'   => new ShowTransactionResource($transaction)
                ]);
            }

            $payosOrderCode = $transaction->payos_order_code ?: $orderCode;

            $detail = $this->payOSService->getPaymentDetail($payosOrderCode);

            if (!$detail) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không lấy được thông tin thanh toán từ PayOS',
                ], 400);
            }

            $status = $detail['status'] ?? null;

            DB::beginTransaction();

            if ($status === 'PAID') {
                // Cập nhật transaction Success
                $transaction->update([
                    'status' => TransactionStatus::Success->value,
                ]);

                // Tìm gói coin tương ứng
                $coin = PriceList::orderByRaw('ABS(price - ?)', [$transaction->amount])->first();

                if ($coin && $user) {
                    // Cộng ví user
                    $user->increment('wallet', $coin->value);

                    // Tạo transaction receive nếu bạn dùng lịch sử ví hai chiều
                    $message = [
                        'value'   => $coin->value,
                        'service' => "việc nạp tiền hệ thống",
                    ];

                    $this->transactionRepository->createTransaction(
                        null,
                        $user,
                        $coin->value,
                        TransactionType::Receive->value,
                        TransactionStatus::Success->value,
                        null,
                        TransactionMessage::message(
                            TransactionType::Receive->value,
                            $message
                        )
                    );
                }
            } elseif (in_array($status, ['CANCELLED', 'FAILED', 'EXPIRED'])) {
                $transaction->update([
                    'status' => TransactionStatus::Failed->value,
                ]);
            }
            // Nếu vẫn PENDING thì giữ nguyên

            DB::commit();

            return response()->json([
                'status' => 200,
                'data'   => [
                    'transaction_status' => $transaction->status,
                    'payos_status'       => $status,
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('PayOS getPayment error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status'  => 500,
                'message' => 'Server error',
            ], 500);
        }
    }
}
