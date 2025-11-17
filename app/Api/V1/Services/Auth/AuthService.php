<?php

namespace App\Api\V1\Services\Auth;

use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use App\Admin\Repositories\ProfileMonthly\ProfileMonthlyRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService as TraitsAuthService;
use App\Admin\Traits\Roles;
use App\Api\V1\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;
use App\Api\V1\Http\Resources\Transaction\TransactionMessage;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Api\V1\Services\PayOS\PayOSService;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Enums\User\UserStatus;
use App\Enums\User\ZodiacSign;
use App\Models\User;
use App\Traits\UseLog;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class AuthService implements AuthServiceInterface
{
    use Setup, Roles, UseLog, TraitsAuthService;
    protected $data;

    protected $repository;
    private $fileService;

    protected $instance;

    public function __construct(
        UserRepositoryInterface $repository,
        FileService $fileService,
        protected AnswerRepositoryInterface $answerRepository,
        protected ProfileMonthlyRepositoryInterface $profileMonthlyRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected PriceListRepositoryInterface $priceListRepository,
        protected DistrictRepositoryInterface $districtRepository,
        protected PayOSService $payOSService,
    ) {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['code'] = $this->createCodeUser();
            $data['status'] = UserStatus::Draft->value;

            $user = $this->repository->create($data);
            $roles = $this->getRoleUser();
            $this->repository->assignRoles($user, [$roles]);

            $last = $this->profileMonthlyRepository
                ->getQueryBuilder()
                ->orderByDesc('month') // hoặc 'id'
                ->first();

            if ($last) {
                $last->increment('total_profiles');
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process create user', $e);
            return false;
        }
    }

    public function draftUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->getCurrentUser();
            $data = $request->validated();
            $data['zodiac_sign'] = ZodiacSign::getZodiacSign($data['birthday']);
            $data['province_id'] = 50;
            $data['status'] = UserStatus::Active->value;

            if (isset($data['avatar']) && $data['avatar']) {
                $avatar = $this->fileService->uploadAvatar('/user', $data['avatar']);
                $data['avatar'] = $avatar;
            }
            if (isset($data['thumbnails']) && $data['thumbnails']) {
                $thumbnails = $this->fileService->uploadMultipleImages('/user', $data['thumbnails']);
                $data['thumbnails'] = array_values($thumbnails);
            }
            if (isset($data['lat']) && isset($data['lng']) && $data['lat'] && $data['lng']) {
                $districtName = $this->getDistrictFromLatLng((float)$data['lat'], (float)$data['lng']);
                if ($districtName) {
                    $data['district_id'] = $this->districtRepository->getQueryBuilder()
                        ->where('name', 'LIKE', "%{$districtName}%")
                        ->value('id');
                }
            }

            $datingTimes = $data['dating_time'];
            unset($data['dating_time']);

            $relationship = $data['relationship'];
            unset($data['relationship']);

            $answers = $data['answer'];
            unset($data['answer']);

            $user = $this->repository->update($user->id, $data);


            foreach ($answers as $value) {
                $answer = $this->answerRepository->findOrFail($value);
                $user->userAnswers()->create(['answer_id' => $value, 'question_id' => $answer->question_id]);
            }

            foreach ($datingTimes as $value) {
                $user->userDatingTimes()->create(['dating_time' => $value]);
            }

            foreach ($relationship as $value) {
                $user->userRelationship()->create(['relationship' => $value]);
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            $this->logError('Failed to process update info user', $e);
            return false;
        }
    }

    public function update(Request $request)
    {
        $this->data = $request->validated();
        $userId = $this->getCurrentUserId();

        if (isset($this->data['avatar']) && $this->data['avatar']) {
            $avatar = $this->fileService->uploadAvatar('/user', $this->data['avatar']);
            $this->data['avatar'] = $avatar;
        }
        if (isset($this->data['thumbnails']) && $this->data['thumbnails']) {
            $thumbnails = $this->fileService->uploadMultipleImages('/user', $this->data['thumbnails']);
            $this->data['thumbnails'] = array_values($thumbnails);
        } else {
            $this->data['thumbnails'] = [];
        }
        if (isset($this->data['birthday']) && $this->data['birthday']) {
            $this->data['zodiac_sign'] = ZodiacSign::getZodiacSign($this->data['birthday']);
        }
        if (isset($this->data['lat']) && isset($this->data['lng']) && $this->data['lat'] && $this->data['lng']) {
            $districtName = $this->getDistrictFromLatLng((float)$this->data['lat'], (float)$this->data['lng']);
            if ($districtName) {
                $this->data['district_id'] = $this->districtRepository->getQueryBuilder()
                    ->where('name', 'LIKE', "%{$districtName}%")
                    ->value('id');
            }
        }

        return $this->repository->update($userId, $this->data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function updateTokenPassword(Request $request)
    {
        $user = $this->repository->findByField('email', $request->input('email'));
        $this->data['token_get_password'] = $this->generateTokenGetPassword();
        $this->instance['user'] = $this->updateObject($user, $this->data);
        return $this;
    }

    public function generateRouteGetPassword($routeName)
    {
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName,
            now()->addMinutes(30),
            [
                'token' => $this->data['token_get_password'],
                'code' => $this->instance['user']->code
            ]
        );
        return $this;
    }

    public function generateRouteActivateAccount($routeName)
    {
        $this->instance['url'] = URL::temporarySignedRoute(
            $routeName,
            now()->addMinutes(30), // Thời hạn liên kết, có thể điều chỉnh
            [
                'token' => $this->data['token_active_account'],
                'code' => $this->instance['user']->code,
            ]
        );
        return $this;
    }

    public function getInstance()
    {
        return $this->instance;
    }

    public function updateObject($user, $data)
    {
        $user->update($data);
        return $user;
    }

    public function createPin(Request $request)
    {
        $this->data = $request->validated();
        $userId = $this->getCurrentUserId();

        return $this->repository->update($userId, $this->data);
    }

    public function updateBank(Request $request)
    {
        $this->data = $request->validated();
        $userId = $this->getCurrentUserId();

        if (isset($this->data['bank_qr']) && $this->data['bank_qr']) {
            $bank_qr = $this->fileService->uploadAvatar('/user', $this->data['bank_qr']);
            $this->data['bank_qr'] = $bank_qr;
        }

        return $this->repository->update($userId, $this->data);
    }

    public function topUpWallet(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $this->data = $request->validated();
            $user = $this->getCurrentUser();

            $price = $this->priceListRepository->findOrFail($this->data['price_id']);

            if (isset($this->data['bill_image']) && $this->data['bill_image']) {
                $bill = $this->fileService->uploadAvatar('/topup', $this->data['bill_image']);
                $this->data['bill_image'] = $bill;
            }

            $message = [
                'value' => $price->value,
                'service' => null,
            ];

            $transaction = $this->transactionRepository->createTransaction(
                $user,
                null,
                $price->price,
                TransactionType::Deposit->value,
                TransactionStatus::Pending->value,
                $this->data['bill_image'] ?? null,
                TransactionMessage::message(TransactionType::Deposit->value, $message)
            );

            $payosData = $this->payOSService->createPayment($transaction->id, $transaction->amount, $transaction->description);

            $transaction->update(['payos_order_code' => $payosData['code'] ?? null]);


            DB::commit();
            return [
                'status' => 200,
                'data' => [
                    'transaction_code' => $transaction->code,
                    'checkoutUrl' => $payosData['checkoutUrl'] ?? null,
                    'qrCode' => $payosData['qrCode'] ?? null,
                    'amount' => $price->price,
                    'description' => $transaction->description,
                    "accountNumber" => $payosData['accountNumber'],
                    "accountName" => $payosData['accountName'],
                ],
            ];
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            DB::rollback();
            return [
                'status' => 400,
                'message' => __('notifyFail'),
            ];
        }
    }

    public function withdraw(Request $request)
    {
        DB::beginTransaction();
        try {
            //code...
            $this->data = $request->validated();
            $user = $this->getCurrentUser();

            $message = [
                'value' => $this->data['amount'],
                'service' => null,
            ];

            $this->transactionRepository->createTransaction(
                $user,
                null,
                $this->data['amount'],
                TransactionType::Withdraw->value,
                TransactionStatus::Pending->value,
                null,
                TransactionMessage::message(TransactionType::Withdraw->value, $message)
            );

            $user->decrement('wallet', $this->data['amount']);

            DB::commit();
            return 200;
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            DB::rollback();
            return 400;
        }
    }

    function getDistrictFromLatLng(float $lat, float $lng): ?string
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "{$lat},{$lng}",
            'key'    => $apiKey,
            'language' => 'vi',  // để trả về tiếng Việt
        ]);

        if (! $response->ok()) {
            return null;
        }

        $data = $response->json();

        if (($data['status'] ?? '') !== 'OK' || empty($data['results'][0]['address_components'])) {
            return null;
        }

        foreach ($data['results'][0]['address_components'] as $component) {
            $types = $component['types'] ?? [];

            // Quận/Huyện thường nằm ở administrative_area_level_2
            if (in_array('administrative_area_level_2', $types)) {
                return $component['long_name']; // ví dụ: "Quận 1", "Huyện Bình Chánh"
            }
        }

        return null;
    }
}
