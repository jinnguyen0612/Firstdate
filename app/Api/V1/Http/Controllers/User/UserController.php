<?php

namespace App\Api\V1\Http\Controllers\User;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Setup;
use App\Api\V1\Http\Requests\User\CreatePinRequest;
use App\Api\V1\Http\Requests\User\DraftUpdateRequest;
use App\Api\V1\Http\Requests\User\GetUserNearByRequest;
use App\Api\V1\Http\Requests\User\LoginRequest;
use App\Api\V1\Http\Requests\User\PinRequest;
use App\Api\V1\Http\Requests\User\RefreshTokenRequest;
use App\Api\V1\Http\Requests\User\RegisterRequest;
use App\Api\V1\Http\Requests\User\ResendOTPRequest;
use App\Api\V1\Http\Requests\User\SendOTPRegisterRequest;
use App\Api\V1\Http\Requests\User\SendOTPRequest;
use App\Api\V1\Http\Requests\User\TopUpWalletRequest;
use App\Api\V1\Http\Requests\User\UpdateBankRequest;
use App\Api\V1\Http\Requests\User\UpdatePasswordRequest;
use App\Api\V1\Http\Requests\User\UpdatePinRequest;
use App\Api\V1\Http\Requests\User\UpdateRequest;
use App\Api\V1\Http\Requests\User\VerifyOTPRequest;
use App\Api\V1\Http\Requests\User\WithdrawRequest;
use App\Api\V1\Http\Resources\User\ProfileResource;
use App\Api\V1\Http\Resources\User\ShowAllUserResource;
use App\Api\V1\Http\Resources\User\UserResource;
use App\Api\V1\Services\Auth\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Api\V1\Repositories\Otp\OtpRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Repositories\UserAnswer\UserAnswerRepositoryInterface;
use App\Api\V1\Support\Response;
use App\Mail\Authentication;
use App\Traits\JwtService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

/**
 * @group Người dùng
 */

class UserController extends Controller
{
    use AuthService, Setup, Response, JwtService;

    private $login;
    private $fileService;
    protected $settingRepository;
    public function __construct(
        AuthServiceInterface $service,
        FileService $fileService,
        SettingRepositoryInterface $settingRepository,
        UserRepositoryInterface $repository,
        protected UserAnswerRepositoryInterface $userAnswerRepository,
        protected OtpRepositoryInterface $otpRepository,
    ) {
        $this->service = $service;
        $this->fileService = $fileService;
        $this->settingRepository = $settingRepository;
        $this->repository = $repository;
    }

    /**
     * Lấy thông tin
     *
     * ? Lấy thông tin
     *
     * <b>Giới tính ( gender )</b>:
     * - 1: Nữ
     * - 2: Nam
     * - 3: Khác
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function show($id = null)
    {
        if ($id == null) {
            $user = auth('user')->user();
        } else {
            $user = $this->repository->findOrFail($id);
        }

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => $id? new UserResource($user): new ProfileResource($user),
        ]);
    }

    /**
     * Đăng ký
     *
     * ? Đăng ký.
     * @bodyParam phone string
     * Số điện thoại. Example: 0961592551
     *
     * @bodyParam email string
     * Email. Example: abc@mevivu.com
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function register(RegisterRequest $request)
    {
        $instance = $this->service->store($request);
        if ($instance) {
            return $this->loginRegister($request, 'user');
        }
        return response()->json([
            'status' => 400,
            'message' => __('Thực hiện không thành công.')
        ], 400);
    }

    /**
     * Cập nhật thông tin tài khoản draft
     *
     * ? Cập nhật thông tin tài khoản draft. Trong đó có: <ul><li><strong>gender</strong>:<ul><li>1: Nam</li><li>2: Nữ</li><li>3: Khác</li></ul></li></ul><ul><li><strong>looking_for</strong>:<ul><li>male: Nam</li><li>female: Nữ</li><li>both: Cả hai</li></ul></li></ul>
     *
     * @bodyParam fullname string
     * Họ và tên. Example: Nguyen Van A
     *
     * @bodyParam birthday date
     * Ngày sinh. Example: 2002-08-20
     *
     * @bodyParam avatar file
     * Ảnh đại diện. Example: file.jpg
     *
     * @bodyParam thumbnails[] file
     * Bộ sưu tập ảnh. Example: file.jpg
     *
     * @bodyParam thumbnails[] file
     * Bộ sưu tập ảnh. Example: file.jpg
     *
     * @bodyParam gender integer
     * Giới tính. Example: 1
     *
     * @bodyParam phone string
     * Số điện thoại. Example: 0961592551
     *
     * @bodyParam email string
     * Email. Example: abc@mevivu.com
     *
     * @bodyParam address string
     * Địa chỉ. Example: 0961592551
     *
     * @bodyParam district_id string
     * Địa chỉ. Example: 538
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function draftUpdate(DraftUpdateRequest $request)
    {
        $instance = $this->service->draftUpdate($request);
        if ($instance) {
            return response()->json([
                'status' => 200,
                'message' => __('Cập nhật thông tin thành công.'),
                'data' => new ProfileResource($instance),
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Thực hiện không thành công.')
        ], 400);
    }

    protected function resolve()
    {
        return Auth::guard('user')->attempt($this->login);
    }

    /**
     * Đăng nhập
     *
     * ? Đăng nhập tài khoản.
     *
     * @bodyParam email string required
     * Tên tài khoản là số marispham1509@gmail.com. Example: 0999999999
     *
     * @bodyParam password string required
     * Mật khẩu của bạn. Example: 123456
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/LoginResource.json
     */
    public function login(LoginRequest $request)
    {
        return $this->loginUser($request, 'user');
    }

    /**
     * Refresh Token
     *
     * ? Refresh Token
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/RefreshTokenResource.json
     */
    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        return $this->refreshToken($request);
    }

    /**
     * Cập nhật thông tin
     *
     * ? Cập nhật thông tin
     *
     * @bodyParam fullname string
     * Họ và tên. Example: Nguyen Van A
     *
     * @bodyParam avatar file
     * Ảnh đại diện. Example: file.jpg
     *
     * @bodyParam thumbnails[] file
     * Bộ sưu tập ảnh. Example: file.jpg
     *
     * @bodyParam thumbnails[] file
     * Bộ sưu tập ảnh. Example: file.jpg
     *
     * @bodyParam gender integer
     * Giới tính. Example: 1
     *
     * @bodyParam phone string
     * Số điện thoại. Example: 0961592551
     *
     * @bodyParam email string
     * Email. Example: abc@mevivu.com
     *
     * @bodyParam address string
     * Địa chỉ. Example: 0961592551
     *
     * @bodyParam district_id string
     * Địa chỉ. Example: 538
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function update(UpdateRequest $request)
    {
        $response = $this->service->update($request);
        // $answer = $this->userAnswerRepository->getAnswerByUserId($response->id);
        // $response->answer = $answer;
        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('notifySuccess'),
                'data' => new ProfileResource($response)
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => __('notifyFail'),
            ], 400);
        }
    }

    /**
     * Đăng xuất
     *
     * ? Đăng xuất
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     */
    public function logout()
    {
        return $this->logoutUser('user');
    }

    /**
     * Gửi/ gửi lại mã xác minh đăng ký
     *
     * ? Gửi/gửi lại mã xác minh đăng ký
     *
     * @bodyParam email string required
     * Email Của bạn. Example: example@gmail.com
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     *
     */
    public function sendOTPRegister(SendOTPRegisterRequest $request)
    {
        $data = $request->validated();
        $data['token_account'] = random_int(1000, 9999);
        $data['token_expiration'] = Carbon::now()->addMinutes(15);
        $mail = [
            'token_active_account' => $data['token_account'],
            'email' => $data['email'],
            'fullname' => 'Bạn'
        ];
        $registerOTP = $this->otpRepository->findByField('email', $data['email']);
        if ($registerOTP) {
            $registerOTP->update($data);
            Mail::to($registerOTP['email'])->send(new Authentication($mail));
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công. Mã xác nhận đã được gửi về email của bạn.')
            ]);
        }

        $registerOTP = $this->otpRepository->create($data);
        Mail::to($registerOTP['email'])->send(new Authentication($mail));

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công. Mã xác nhận đã được gửi về email của bạn.')
        ]);
    }

    /**
     * Gửi/gửi lại mã xác minh
     *
     * ? Gửi/gửi lại mã xác minh
     *
     * @bodyParam email string required
     * Email Của bạn. Example: example@gmail.com
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     *
     */
    public function sendOTP(SendOTPRequest $request)
    {
        $email = $request->input('email');

        $user = $this->repository->findByField('email', $email);

        $otp = $this->otpRepository->findByField('email', $email);
        $otp = is_object($otp) ? $otp : (is_iterable($otp) ? collect($otp)->first() : null);

        if (!$otp) {
            $otp = $this->otpRepository->create([
                'email' => $email,
                'token_account' => random_int(1000, 9999),
                'token_expiration' => Carbon::now()->addMinutes(15),
            ]);
        } else {
            // Nếu có rồi thì cập nhật
            $otp->token_account = random_int(1000, 9999);
            $otp->token_expiration = Carbon::now()->addMinutes(15);
            $otp->save();
        }

        $mail = [
            'fullname' => $user['fullname'] ?? 'Bạn',
            'email' => $otp->email,
            'token_active_account' => $otp->token_account
        ];

        Mail::to($otp->email)->send(new Authentication($mail));

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công. Mã xác nhận đã được gửi về email của bạn.')
        ]);
    }


    /**
     * Xác nhận mã xác minh
     *
     * ? Xác nhận mã xác minh
     *
     * @bodyParam email string required
     * Email Của bạn. Example: example@gmail.com
     *
     * @bodyParam token_account string required
     * OTP Của bạn. Example: 1234
     *
     * @responseFile 200 App/Api/V1/Http/Resources/BaseResource.json
     *
     */
    public function verifyOTP(VerifyOTPRequest $request)
    {
        $user = $this->otpRepository->findByField('email', $request->input('email'));
        if ($user && $user->token_account == $request->input('token_account') && $user->token_expiration > Carbon::now()) {
            $user->update(['token_account' => null, 'token_expiration' => null]);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Mã xác thực chưa chính xác hoặc đã hết hạn.')
        ], 400);
    }

    /**
     * Lấy danh sách người dùng trong phạm vi
     *
     * Lấy danh sách người dùng trong phạm vi với người dùng hiện tại.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @queryParam page integer Số trang. Example: 1
     * @queryParam limit integer Số lượng kết quả trên một trang. Example: 10
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 1,
     *              "avatar": "public/assets/images/default-avatar.png",
     *              "full_name": "Nguyễn Thành Trung",
     *              "age": 24,
     *              "province": "Tỉnh Hà Giang",
     *              "bio": null,
     *              "zodiac_sign": "Aries"
     *          },
     *          {
     *              "id": 2,
     *              "avatar": "public/assets/images/default-avatar.png",
     *              "full_name": "Nguyễn Thành Trung",
     *              "age": 24,
     *              "province": "Tỉnh Hà Giang",
     *              "bio": null,
     *              "zodiac_sign": "Aries"
     *          }
     *      ]
     * }
     *
     * @param  App\Api\V1\Http\Requests\Auth\GetUserNearByRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getUserNearBy(GetUserNearByRequest $request)
    {
        $paginate = $request->validated();
        $user = $this->getCurrentUser();

        $isReroll = $request->get('reroll', false);
        if ($isReroll) {
            if ($user->reroll <= 0) return response()->json([
                'status' => 400,
                'message' => __('Bạn đã hết lượt roll.')
            ], 400);
            $user->decrement('reroll');
        }

        $data = $this->repository->getUserNearBy($user->id, ...$paginate);

        if ($isReroll && $data->isEmpty()) {
            $user->increment('reroll');
            return response()->json([
                'status' => 404,
                'message' => __('Chúng tôi đang tìm thêm đối tượng mới cho bạn. Vui lòng thử lại sau.')
            ], 400);
        }

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => ShowAllUserResource::collection($data),
        ]);
    }

    /**
     * Tạo mới mã Pin
     *
     * ? Tạo mới mã Pin
     *
     * @bodyParam pin string
     * Mã PIN. Example: 123456
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function updatePin(PinRequest $request)
    {
        $response = $this->service->createPin($request);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('notifySuccess'),
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => __('notifyFail'),
            ], 400);
        }
    }

    /**
     * Verify Pin
     *
     * ? Verify Pin
     *
     * @bodyParam pin string
     * Mã PIN. Example: 123456
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function verifyPin(PinRequest $request)
    {
        $user = $this->getCurrentUser();

        if ($user->pin != null) {
            if ($user->pin == $request->input('pin')) {
                return response()->json([
                    'status' => 200,
                    'message' => __('Xác thực thành công'),
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => __('Mã Pin bạn nhập không đúng xin vui lòng kiểm tra lại'),
                ], 400);
            }
        } else return response()->json([
            'status' => 404,
            'message' => __('Not found'),
        ], 404);
    }

    /**
     * Thêm thông tin ngân hàng
     *
     * ? Thêm thông tin ngân hàng
     *
     * @bodyParam price_id string
     * Mã giá trao đổi. Example: 123456
     *
     * @bodyParam bill_image file
     * Hình ảnh hóa đơn chuyển khoản. Example: file.jpg
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function updateBank(UpdateBankRequest $request)
    {
        $response = $this->service->updateBank($request);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('Thêm thông tin ngân hàng thành công.'),
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => __('notifyFail'),
            ], 400);
        }
    }
}
