<?php

namespace App\Api\V1\Services\Matching;

use App\Admin\Traits\AuthService;
use App\Api\V1\Repositories\Deal\DealRepositoryInterface;
use App\Api\V1\Services\Matching\MatchingServiceInterface;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Api\V1\Repositories\Notification\NotificationRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Api\V1\Support\AuthSupport;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Process\ProcessStatus;
use App\Enums\Process\ProcessType;
use App\Enums\User\Gender;
use App\Enums\User\UserStatus;
use App\Models\Process;
use App\Traits\SendNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatchingService implements MatchingServiceInterface
{
    use AuthSupport, AuthService, SendNotification;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;

    protected $repository;

    public function __construct(
        MatchingRepositoryInterface $repository,
        protected DealRepositoryInterface $dealRepository,
        protected NotificationRepositoryInterface $notificationRepository,
        protected UserRepositoryInterface $userRepository
    ) {
        $this->repository = $repository;
    }

    public function add(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $user = $this->getCurrentUser();
            $data['user_id'] = $user->id;
            $userLoved = $this->userRepository->getQueryBuilder()->where('id', $data['user_loved_id'])
                ->where('status', UserStatus::Active->value)->first();

            if (!$userLoved) {
                return [
                    'success' => false,
                    'status' => 404,
                    'message' => __('Người dùng không tồn tại.')
                ];
            }

            // Đã like người kia chưa?
            if ($this->repository->getBy([
                'user_id' => $user->id,
                'user_loved_id' => $data['user_loved_id'],
            ])->isNotEmpty()) {
                return [
                    'success' => false,
                    'status' => 409,
                    'message' => __('Bạn đã thích người này rồi.')
                ];
            }

            if(isset($data['is_supper_love']) && $data['is_supper_love']===0){
                $data['support_money'] = null;
            }

            $this->repository->create($data);

            // Người kia có like lại mình không?
            $checkHaveLoved = $this->repository->getBy([
                'user_id' => $data['user_loved_id'],
                'user_loved_id' => $user->id,
            ])->first();

            if ($checkHaveLoved) {
                $user1 = $user;
                $user2 = $checkHaveLoved->user;

                $isSameGender = $user1->gender == $user2->gender;
                $hasOther = in_array(Gender::Other, [$user1->gender, $user2->gender]);

                if ($isSameGender || $hasOther) {
                    // Không phân biệt giới tính
                    $deal = $this->dealRepository->create([
                        'user_female_id' => $user1->id,
                        'user_male_id' => $data['user_loved_id'],
                    ]);
                } else {
                    // Phân biệt nam nữ đúng vị trí
                    $deal = $this->dealRepository->create([
                        'user_female_id' => $user1->gender == Gender::Female ? $user1->id : $user2->id,
                        'user_male_id' => $user1->gender == Gender::Male ? $user1->id : $user2->id,
                    ]);
                }
                $now = now();
                $after1Hours = $now->copy()->addHours(1);

                $title = 'Yêu cầu chọn 5 quận để lên kèo hẹn hò';
                if ($after1Hours->isSameDay($now) || $deal->user_female->gender != Gender::Female) {
                    $message = 'Vui lòng chọn 5 quận để lên kèo hẹn hò. Sau ít nhất 8 tiếng nếu bạn không chọn, hệ thống sẽ tự động hủy tương hợp và hủy cuộc hẹn.';
                    $short_message = 'Vui lòng chọn 5 quận để lên kèo hẹn hò.';

                    $notification = $this->notificationRepository->create([
                        'user_id' => $deal->user_female_id,
                        'title' => $title,
                        'message' => $message,
                        'short_message' => $short_message,
                        'status' => NotificationStatus::NOT_READ->value,
                    ]);
                    //push notification
                    // $this->sendNotificationRecord($notification, $deal->user_female->device_token);
                    Process::create([
                        'type' => ProcessType::MakeDeal->value,
                        'user_id' => $deal->user_female_id,
                        'deal_id' => $deal->id,
                        'sent_count' => 1,
                        'next_send_at' => $after1Hours,
                        'title' => $title,
                        'key' => 'quận',
                        'status' => ProcessStatus::Running->value,
                    ]);
                } else if ($deal->user_female->gender == Gender::Female) {
                    $nextSendAt = $now->copy()->addDay()->startOfDay()->addHours(9);
                    Process::create([
                        'type' => ProcessType::MakeDeal->value,
                        'user_id' => $deal->user_female_id,
                        'deal_id' => $deal->id,
                        'sent_count' => 0,
                        'next_send_at' => $nextSendAt,
                        'title' => $title,
                        'key' => 'quận',
                        'status' => ProcessStatus::Running->value
                    ]);
                }
                DB::commit();
                return [
                    'success' => true,
                    'message' => __('Thích thành công.'),
                    'is_matching' => true,
                ];
            }

            DB::commit();
            return [
                'success' => true,
                'message' => __('Thích thành công.'),
                'is_matching' => false,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating matching: ' . $e->getMessage());
            return [
                'success' => false,
                'status' => 400,
                'message' => __('Lỗi hệ thống. Hãy kiểm tra lại.')
            ];
        }
    }

    public function delete(Request $request)
    {
        try {
            //code...
            $deleted = $this->repository->getQueryBuilder()->where('user_id', $request->user_id)->where('user_loved_id', $request->user_loved_id)->delete();

            return $deleted;
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error deleting matching: ' . $th->getMessage());
            return false;
        }
    }
}
