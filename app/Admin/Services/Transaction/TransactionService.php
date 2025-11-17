<?php

namespace App\Admin\Services\Transaction;

use App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use App\Admin\Services\Transaction\TransactionServiceInterface;
use  App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Models\Partner;
use App\Models\PriceList;
use App\Models\User;
use App\Traits\UseLog;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Securities\Price;

class TransactionService implements TransactionServiceInterface
{
    use Setup, UseLog;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(
        TransactionRepositoryInterface $repository,
        protected UserRepositoryInterface $userRepository
    ) {
        $this->repository = $repository;
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['updated_at'] = now();
            $transaction = $this->repository->update($data['id'], $data);
            $user = $transaction->from;

            if ($transaction['type'] == TransactionType::Deposit->value && $data['status'] == TransactionStatus::Success->value) {

                if ($transaction['from_type'] == Partner::class) {
                    $user->increment('wallet', $transaction['amount']);
                    $message = [
                        'value' => $transaction['amount'],
                        'service' => "việc nạp tiền hệ thống",
                    ];
                    $this->repository->createTransaction(
                        null,
                        $user,
                        $transaction['amount'],
                        TransactionType::Receive->value,
                        TransactionStatus::Success->value,
                        null,
                        TransactionMessage::message(TransactionType::Receive->value, $message)
                    );
                } else {
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
                }
            }

            if ($transaction['type'] == TransactionType::Withdraw->value && $data['status'] == TransactionStatus::Failed->value) {
                $user->increment('wallet', $transaction['amount']);
                $message = [
                    'value' => $transaction['amount'],
                    'service' => "việc rút tiền hệ thống thất bại",
                ];
                $this->repository->createTransaction(
                    null,
                    $user,
                    $transaction['amount'],
                    TransactionType::Receive->value,
                    TransactionStatus::Success->value,
                    null,
                    TransactionMessage::message(TransactionType::Receive->value, $message)
                );
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to update', $e);
            return false;
        }
    }
}
