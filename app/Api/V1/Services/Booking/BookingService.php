<?php

namespace App\Api\V1\Services\Booking;

use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Api\V1\Repositories\Booking\BookingRepositoryInterface;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Api\V1\Services\Booking\BookingServiceInterface;
use Illuminate\Http\Request;
use App\Api\V1\Support\AuthSupport;
use App\Enums\Booking\BookingDeposit;
use App\Enums\Booking\BookingStatus;
use App\Enums\Process\ProcessType;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Enums\User\Gender;
use App\Models\Process;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingService implements BookingServiceInterface
{
    use AuthSupport, AuthService;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(
        BookingRepositoryInterface $repository,
        protected MatchingRepositoryInterface $matchingRepository,
        protected BookingRepositoryInterface $bookingRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected SettingRepositoryInterface $settingRepository,
    ) {
        $this->repository = $repository;
    }

    public function payDeposit($dealId)
    {
        DB::beginTransaction();
        try {
            $currentUser = $this->getCurrentUser();

            $booking = $this->bookingRepository->getQueryBuilder()
                ->where('deal_id', $dealId)
                ->where(function ($query) use ($currentUser) {
                    $query->where('user_female_id', $currentUser->id)
                        ->orWhere('user_male_id', $currentUser->id);
                })
                ->where(function ($query){
                    $query->where('status', BookingStatus::Pending->value)
                        ->orWhere('status', BookingStatus::Confirmed->value);
                })->first();

            if ($booking == null) return 404;

            if ($booking->depositForUser($currentUser->id) > 0) return 409;

            if($currentUser->wallet < $booking->getDepositNumber($currentUser->id)) return 400;

            if($booking->user_female_id == $currentUser->id){
                $userLovedId = $booking->user_male_id;
            }else{
                $userLovedId = $booking->user_female_id;
            }

            $totalDeposit = (float) $booking->getDepositNumber($currentUser->id);
            $supportMoney = 0;

            $matching = $this->matchingRepository->getQueryBuilder()
                ->where('user_id', $currentUser->id)
                ->where('user_loved_id', $userLovedId)
                ->first();

            if($matching != null && $matching->is_supper_love == true){
                $totalDeposit+= (float) $matching->support_money;
                $supportMoney += (float) $matching->support_money;
            }

            if($currentUser != null && $currentUser->is_subsidy_offer === 1){
                $transportation_support_rate = $this->settingRepository->getQueryBuilder()->where('setting_key', 'transportation_support_rate')->first()->plain_value;
                $totalDeposit+= (float) $transportation_support_rate;
                $supportMoney += (float) $transportation_support_rate;
            }


            $currentUser->decrement('wallet', $totalDeposit);

            $booking->deposits()->create([
                'user_id' => $currentUser->id,
                'amount' => $booking->getDepositNumber($currentUser->id),
                'status' => BookingDeposit::Paid->value,
                'support_money' => $supportMoney,
                'paid_at' => now(),
            ]);

            $this->transactionRepository->createTransaction(
                $currentUser,
                null,
                $totalDeposit,
                TransactionType::Payment->value,
                TransactionStatus::Success->value,
                null,
                'Thanh toán cọc cho cuộc hẹn',
            );

            Process::where('deal_id', $dealId)->where('user_id', $currentUser->id)->where('type', ProcessType::PayDeposit->value)->delete();

            DB::commit();
            return 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Pay deposit failed: ' . $th->getMessage());
            return 400;
        }
    }
}
