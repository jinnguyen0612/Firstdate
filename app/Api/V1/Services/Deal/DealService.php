<?php

namespace App\Api\V1\Services\Deal;

use App\Admin\Repositories\Partner\PartnerRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Setup;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Api\V1\Repositories\Booking\BookingRepositoryInterface;
use App\Api\V1\Repositories\Deal\DealRepositoryInterface;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepository;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Deal\DealServiceInterface;
use Illuminate\Http\Request;
use App\Api\V1\Support\AuthSupport;
use App\Enums\Booking\BookingDeposit;
use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Process\ProcessStatus;
use App\Enums\Process\ProcessType;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Enums\User\Gender;
use App\Models\Partner;
use App\Models\Process;
use App\Traits\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DealService implements DealServiceInterface
{
    use AuthSupport, AuthService, SendNotification, Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(
        DealRepositoryInterface $repository,
        protected MatchingRepositoryInterface $matchingRepository,
        protected BookingRepositoryInterface $bookingRepository,
        protected UserRepositoryInterface $userRepository,
        protected PartnerRepositoryInterface $partnerRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected NotificationRepositoryInterface $notificationRepository,
    ) {
        $this->repository = $repository;
    }

    public function chooseDistrictOptions(Request $request)
    {
        $data = $request->validated();
        $currentUserId = $this->getCurrentUserId();
        DB::beginTransaction();
        try {
            $deal = $this->repository->findOrFailWithStatus($data['id'], DealStatus::Pending->value);
            if ($deal->dealDistrictOptions()->count() >= 5) return 409;
            foreach ($data['districts'] as $value) {

                $deal->dealDistrictOptions()->create([
                    'district_id' => $value
                ]);
            }
            Process::where('deal_id', $deal->id)->where('user_id', $currentUserId)->where('type', ProcessType::MakeDeal->value)->delete();

            $userMale = $deal->user_male;
            $title = 'Yêu cầu chọn một trong 5 quận đã chọn.';
            $this->createProcess($title, 'quận', $deal, $userMale, ProcessType::MakeDeal->value, 'male');

            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Deal district option: ' . $e->getMessage());
            return 400;
        }
    }

    public function chooseDistrictFromOptions($id)
    {
        $currentUserId = $this->getCurrentUserId();

        $deal = $this->repository->getQueryBuilder()
            ->whereHas('dealDistrictOptions', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->where(function ($query) use ($currentUserId) {
                $query->where('user_female_id', $currentUserId)
                    ->orWhere('user_male_id', $currentUserId);
            })
            ->where('status', DealStatus::Pending->value)
            ->first();

        if ($deal == null) return 404;

        $hasChosen = $deal->dealDistrictOptions()->where('is_chosen', 1)->exists();

        if ($hasChosen) return 409;

        $deal->dealDistrictOptions()->where('id', $id)->update(['is_chosen' => 1]);

        Process::where('deal_id', $deal->id)->where('user_id', $currentUserId)->where('type', ProcessType::MakeDeal->value)->delete();

        $userFemale = $deal->user_female;
        $title = 'Yêu cầu chọn 5 quán để lên kèo hẹn hò.';
        $this->createProcess($title, 'quán', $deal, $userFemale, ProcessType::MakeDeal->value, 'female');

        return 200;
    }

    public function choosePartnerOptions(Request $request)
    {
        $data = $request->validated();
        $currentUserId = $this->getCurrentUserId();
        DB::beginTransaction();
        try {
            $deal = $this->repository->findOrFailWithStatus($data['id'], DealStatus::Pending->value);
            if ($deal->dealPartnerOptions()->count() >= 5) return 409;
            foreach ($data['partners'] as $value) {

                $deal->dealPartnerOptions()->create([
                    'partner_id' => $value
                ]);
            }

            Process::where('deal_id', $deal->id)->where('user_id', $currentUserId)->where('type', ProcessType::MakeDeal->value)->delete();

            $userMale = $deal->user_male;
            $title = 'Yêu cầu chọn một trong 5 quán đã chọn.';
            $this->createProcess($title, 'quán', $deal, $userMale, ProcessType::MakeDeal->value, 'male');

            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Deal partner option: ' . $e->getMessage());
            return 400;
        }
    }

    public function choosePartnerFromOptions($id)
    {
        $currentUserId = $this->getCurrentUserId();

        $deal = $this->repository->getQueryBuilder()
            ->whereHas('dealPartnerOptions', function ($query) use ($id) {
                $query->where('id', $id);
            })
            ->where(function ($query) use ($currentUserId) {
                $query->where('user_female_id', $currentUserId)
                    ->orWhere('user_male_id', $currentUserId);
            })
            ->where('status', DealStatus::Pending->value)
            ->first();

        if ($deal == null) return 404;

        $hasChosen = $deal->dealPartnerOptions()->where('is_chosen', 1)->exists();

        if ($hasChosen) return 409;

        $deal->dealPartnerOptions()->where('id', $id)->update(['is_chosen' => 1]);

        Process::where('deal_id', $deal->id)->where('user_id', $currentUserId)->where('type', ProcessType::MakeDeal->value)->delete();

        $userFemale = $deal->user_female;
        $title = 'Yêu cầu 5 khoảng thời gian để lên kèo hẹn hò.';
        $this->createProcess($title, 'khoảng thời gian', $deal, $userFemale, ProcessType::MakeDeal->value, 'female');

        return 200;
    }

    public function chooseDateOptions(Request $request)
    {
        $data = $request->validated();
        $currentUserId = $this->getCurrentUserId();
        DB::beginTransaction();
        try {
            $deal = $this->repository->findOrFailWithStatus($data['id'], DealStatus::Pending->value);
            if ($deal->dealDateOptions()->count() >= 5) return 409;
            foreach ($data['dates'] as $date) {

                $deal->dealDateOptions()->create([
                    'date' => $date['date'],
                    'from' => $date['from'],
                    'to' => $date['to'],
                ]);
            }

            Process::where('deal_id', $deal->id)->where('user_id', $currentUserId)->where('type', ProcessType::MakeDeal->value)->delete();

            $userMale = $deal->user_male;
            $title = 'Yêu cầu chọn một trong 5 khoảng thời gian đã chọn.';
            $this->createProcess($title, 'khoảng thời gian', $deal, $userMale, ProcessType::MakeDeal->value, 'male');

            DB::commit();
            return 200;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Deal date option: ' . $e->getMessage());
            return 400;
        }
    }

    public function chooseDateFromOptions($id)
    {
        DB::beginTransaction();
        try {
            $currentUserId = $this->getCurrentUserId();
            $deal = $this->repository->getQueryBuilder()
                ->whereHas('dealDateOptions', function ($query) use ($id) {
                    $query->where('id', $id);
                })
                ->where(function ($query) use ($currentUserId) {
                    $query->where('user_female_id', $currentUserId)
                        ->orWhere('user_male_id', $currentUserId);
                })
                ->where('status', DealStatus::Pending->value)
                ->first();

            if ($deal == null) return 404;

            $hasChosen = $deal->dealDateOptions()->where('is_chosen', 1)->exists();

            if ($hasChosen) return 409;

            $deal->dealDateOptions()->where('id', $id)->update(['is_chosen' => 1]);

            $code = $this->createCodeBooking();
            $partnerId = $deal->dealPartnerOptions()->where('is_chosen', 1)->first()?->partner_id;

            $this->bookingRepository->create([
                'code' => $code,
                'user_female_id' => $deal->user_female_id,
                'user_male_id' => $deal->user_male_id,
                'partner_id' => $partnerId,
                'deal_id' => $deal->id,
                'date' => $deal->dealDateOptions()->where('is_chosen', 1)->first()->date,
            ]);

            Process::where('deal_id', $deal->id)->where('user_id', $currentUserId)->where('type', ProcessType::MakeDeal->value)->delete();

            $title = 'Yêu cầu đặt cọc cho cuộc hẹn có mã #' . $deal->id;
            $this->createProcess($title, null, $deal, null, ProcessType::PayDeposit->value, 'both');

            //Gửi thông báo đến partner
            $this->notificationRepository->create([
                    'partner_id' => $partnerId,
                    'title' => 'Yêu cầu xác nhận đặt bàn cho cuộc hẹn #' . $code . '!',
                    'message' => 'Bạn có yêu cầu xác nhận đặt bàn cho cuộc hẹn #' . $code . '! Vui lòng xác nhận ngay nhé!',
                    'short_message' => 'Bạn có yêu cầu xác nhận đặt bàn mới!',
                    'status' => NotificationStatus::NOT_READ->value,
                ]);

            DB::commit();
            return 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error creating Deal date option: ' . $th->getMessage());
            return 400;
        }
    }

    public function cancel(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $currentUserId = $this->getCurrentUserId();

            $deal = $this->repository->getQueryBuilder()
                ->where('id', $data['id'])
                ->where(function ($query) use ($currentUserId) {
                    $query->where('user_female_id', $currentUserId)
                        ->orWhere('user_male_id', $currentUserId);
                })
                ->where(function ($query) {
                    $query->where('status', DealStatus::Pending->value)
                        ->orWhere('status', DealStatus::Confirmed->value);
                })
                ->first();

            if ($deal == null) return 404;

            $deal->update(['status' => DealStatus::Cancelled->value]);

            $deal->dealCancellation()->create(['canceled_by' => $currentUserId, 'reason' => $data['reason'], 'canceled_at' => now()]);

            $this->matchingRepository->deleteBy(['user_id' => $deal->user_male_id, 'user_loved_id' => $deal->user_female_id]);
            $this->matchingRepository->deleteBy(['user_id' => $deal->user_female_id, 'user_loved_id' => $deal->user_male_id]);

            $booking = $this->bookingRepository->getQueryBuilder()
                ->where('deal_id', $deal->id)
                ->first();

            if ($booking != null) {
                $booking->update(['status' => BookingStatus::Cancelled->value]);
                if (!empty($booking->deposits)) {
                    foreach ($booking->deposits as $deposit) {
                        if (($deposit->user_id != $currentUserId) ||
                            ($deposit->user_id == $currentUserId && $booking->time == null) ||
                            ($deposit->user_id == $currentUserId && $booking->time != null && Carbon::parse("{$booking->date} {$booking->time}")->gt(now()->addDay()))
                        ) {

                            $user = $this->userRepository->find($deposit->user_id);

                            $totalDeposit = (int) $deposit->amount + (int) $deposit->support_money??0;

                            $message = [
                                'value' => $totalDeposit,
                                'service' => 'đã có người hủy cuộc hẹn ngày ' . $booking->date,
                            ];

                            $this->transactionRepository->createTransaction(
                                null,
                                $user,
                                $totalDeposit,
                                TransactionType::Refund->value,
                                TransactionStatus::Success->value,
                                null,
                                TransactionMessage::message(TransactionType::Refund->value, $message)
                            );
                            $user->increment('wallet', $totalDeposit);
                            $deposit->update(['status' => BookingDeposit::Refunded->value, 'refunded_at' => now(), 'refunded_amount' => $totalDeposit]);
                        } else {
                            $deposit->update(['status' => BookingDeposit::Forfeited->value]);

                            $ortherDeposit = $booking->deposits->firstWhere('user_id', '!=', $currentUserId);

                            if ($ortherDeposit != null) {
                                $ortherUser = $this->userRepository->find($ortherDeposit->user_id);
                                $message = [
                                    'value' => (((2 * $deposit->amount) / 5) + $deposit->support_money??0),
                                    'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                                ];
                                $this->transactionRepository->createTransaction(
                                    null,
                                    $ortherUser,
                                    (((2 * $deposit->amount) / 5) + $deposit->support_money??0),
                                    TransactionType::Refund->value,
                                    TransactionStatus::Success->value,
                                    null,
                                    TransactionMessage::message(TransactionType::Refund->value, $message)
                                );
                                $ortherUser->increment('wallet', (((2 * $deposit->amount) / 5) + $deposit->support_money??0));

                                $partner = $this->partnerRepository->find($booking->partner_id);

                                $message = [
                                    'value' => $deposit->amount / 5,
                                    'service' => 'tiền phạt của người hủy cuộc hẹn ngày ' . $booking->date,
                                ];

                                $this->transactionRepository->createTransaction(
                                    null,
                                    $partner,
                                    $deposit->amount / 5,
                                    TransactionType::Refund->value,
                                    TransactionStatus::Success->value,
                                    null,
                                    TransactionMessage::message(TransactionType::Refund->value, $message)
                                );
                                $partner->increment('wallet', $deposit->amount / 5);
                            }
                        }
                    }
                }
            }

            DB::commit();
            return 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Cancel deal failed: ' . $th->getMessage());
            return 400;
        }
    }

    private function createProcess($title, $key, $deal, $user, $type, $for)
    {
        $now = now();
        $after1Hours = $now->copy()->addHours(1);

        if ($after1Hours->isSameDay($now) || $user->gender != Gender::Female->value) {
            if ($for == 'female') {
                $message = 'Vui lòng chọn 5 ' . $key . ' để lên kèo hẹn hò. Sau ít nhất 8 tiếng nếu bạn không chọn, hệ thống sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                $short_message = 'Vui lòng chọn 5 ' . $key . ' để lên kèo hẹn hò.';
            } else if ($for == 'male') {
                $message = 'Bạn ghép cặp của bạn đã hoàn thành chọn các ' . $key . '. Vui lòng chọn một trong 5 ' . $key . ' đó. Sau ít nhất 8 tiếng sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                $short_message = 'Bạn ghép cặp của bạn đã hoàn thành chọn các ' . $key . '. Vui lòng chọn một trong 5 ' . $key . ' đó.';
            } else if ($for == 'both') {
                $message = 'Bạn có yêu cầu đặt cọc cho cuộc hẹn có mã #' . $deal->id . '. Vui lồng đặt cọc sớm nhất có thể để tiến hành cuộc hẹn. Sau 8 tiếng nếu bạn không đặt cọc, hệ thống sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                $short_message = 'Yêu cầu đặt cọc cho cuộc hẹn có mã #' . $deal->id;
            }

            if ($for == 'both') {
                $notificationMale = $this->notificationRepository->create([
                    'user_id' => $deal->user_male->id,
                    'title' => $title,
                    'message' => $message,
                    'short_message' => $short_message,
                    'status' => NotificationStatus::NOT_READ->value,
                ]);
                $notificationFemale = $this->notificationRepository->create([
                    'user_id' => $deal->user_female->id,
                    'title' => $title,
                    'message' => $message,
                    'short_message' => $short_message,
                    'status' => NotificationStatus::NOT_READ->value,
                ]);
                //push notification
                // $this->sendNotificationRecord($notificationMale, $deal->user_male->device_token);
                // $this->sendNotificationRecord($notificationFemale, $deal->user_female->device_token);

                Process::create([
                    'type' => $type,
                    'user_id' => $deal->user_male->id,
                    'deal_id' => $deal->id,
                    'sent_count' => 1,
                    'next_send_at' => $after1Hours,
                    'title' => $title,
                    'key' => $key,
                    'status' => ProcessStatus::Running->value,
                ]);
                Process::create([
                    'type' => $type,
                    'user_id' => $deal->user_female->id,
                    'deal_id' => $deal->id,
                    'sent_count' => 1,
                    'next_send_at' => $after1Hours,
                    'title' => $title,
                    'key' => $key,
                    'status' => ProcessStatus::Running->value,
                ]);
            } else {
                $notification = $this->notificationRepository->create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'message' => $message,
                    'short_message' => $short_message,
                    'status' => NotificationStatus::NOT_READ->value,
                ]);
                //push notification
                // $this->sendNotificationRecord($notification, $user->device_token);
                Process::create([
                    'type' => $type,
                    'user_id' => $user->id,
                    'deal_id' => $deal->id,
                    'sent_count' => 1,
                    'next_send_at' => $after1Hours,
                    'title' => $title,
                    'key' => $key,
                    'status' => ProcessStatus::Running->value,
                ]);
            }
        } else if ($user->gender == Gender::Female->value) {
            $nextSendAt = $now->copy()->addDay()->startOfDay()->addHours(9);
            if ($for == 'both') {
            } else {
                Process::create([
                    'type' => $type,
                    'user_id' => $user->id,
                    'deal_id' => $deal->id,
                    'sent_count' => 0,
                    'next_send_at' => $nextSendAt,
                    'title' => $title,
                    'key' => 'quận',
                    'status' => ProcessStatus::Running->value
                ]);
            }
        }
    }
}
