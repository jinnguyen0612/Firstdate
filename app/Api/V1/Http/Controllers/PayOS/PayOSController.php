<?php

namespace App\Api\V1\Http\Controllers\PayOS;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Models\PriceList;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayOSController extends Controller
{
    public function webhook(Request $request)
    {
        Log::info('PayOS webhook received', $request->all());
        $payload = $request->all();

        // Xác minh chữ ký (rất quan trọng)
        if (!$this->verifyChecksum($payload)) {
            Log::warning('PayOS webhook: invalid signature');
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $data = $payload['data'] ?? [];
        $orderCode = $data['orderCode'] ?? null;
        $status = $data['status'] ?? null;

        if (!$orderCode) {
            return response()->json(['message' => 'Missing orderCode'], 400);
        }

        $transaction = Transaction::where('id', $orderCode)->first();
        $user = $transaction->from;
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Cập nhật trạng thái
        if ($status === 'PAID') {
            $transaction->update(['status' => TransactionStatus::Success->value]);

            $coin = PriceList::orderByRaw('ABS(price - ?)', [$transaction['amount']])->first();
            $user->increment('wallet', $coin->value);
            $message = [
                'value' => $coin->value,
                'service' => "việc nạp tiền hệ thống",
            ];
            $this->repository->createTransaction(
                null,
                $user,
                $coin->value,
                TransactionType::Receive->value,
                TransactionStatus::Success->value,
                null,
                TransactionMessage::message(TransactionType::Receive->value, $message)
            );
        } else {
            $transaction->update(['status' => TransactionStatus::Failed->value]);
        }

        Log::info("Transaction {$orderCode} updated to {$status}");
        return response()->json(['message' => 'Webhook handled']);
    }

    private function verifyChecksum(array $payload): bool
    {
        $checksumKey = env('PAYOS_CHECKSUM_KEY');
        $signature = $payload['signature'] ?? '';
        unset($payload['signature']);

        ksort($payload);
        $dataString = '';
        foreach ($payload as $key => $value) {
            $dataString .= is_array($value) ? json_encode($value) : $value;
        }

        $hash = hash_hmac('sha256', $dataString, $checksumKey);
        return hash_equals($hash, $signature);
    }
}
