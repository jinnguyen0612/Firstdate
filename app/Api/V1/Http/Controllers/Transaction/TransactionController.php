<?php

namespace App\Api\V1\Http\Controllers\Transaction;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Services\Transaction\TransactionServiceInterface;
use App\Admin\Traits\AuthService;
use App\Admin\Traits\Setup;
use App\Api\V1\Http\Requests\User\TopUpWalletRequest;
use App\Api\V1\Http\Requests\User\WithdrawRequest;
use App\Api\V1\Repositories\Otp\OtpRepositoryInterface;
use App\Api\V1\Services\Auth\AuthServiceInterface;
use App\Api\V1\Services\PayOS\PayOSService;
use App\Api\V1\Support\Response;
use App\Traits\JwtService;

/**
 * @group Transaction
 */

class TransactionController extends Controller
{
    use AuthService, Setup, Response, JwtService;

    private $login;
    private $fileService;
    protected $settingRepository;
    public function __construct(
        TransactionServiceInterface $service,
        TransactionRepositoryInterface $repository,
        FileService $fileService,
        SettingRepositoryInterface $settingRepository,
        protected OtpRepositoryInterface $otpRepository,
        protected PayOSService $payOSService,
        protected AuthServiceInterface $authService,
    ) {
        $this->service = $service;
        $this->fileService = $fileService;
        $this->settingRepository = $settingRepository;
        $this->repository = $repository;
    }

    /**
     * Nạp tim vào ví
     *
     * ? Nạp tim vào ví
     *
     * @bodyParam price_id string
     * Mã giá trao đổi. Example: 123456
     * 
     * @bodyParam bill_image file
     * Hình ảnh hóa đơn chuyển khoản. Example: file.jpg
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function topUpWallet(TopUpWalletRequest $request)
    {
        $response = $this->authService->topUpWallet($request);

        if ($response && $response['status'] == 200) {
            return response()->json($response, 200);
        } else {
            return response()->json($response, 400);
        }
    }

    public function cancel()
    {
        // Xử lý hủy giao dịch nếu cần thiết
        return response()->json(['message' => 'Transaction cancelled']);
    }

    /**
     * Rút tiền về tài khoản
     *
     * ? Rút tiền về tài khoản
     *
     * @bodyParam price_id string
     * Mã giá trao đổi. Example: 123456
     *
     * @responseFile 200 App/Api/V1/Http/Resources/User/UserResource.json
     */
    public function withdraw(WithdrawRequest $request)
    {
        $response = $this->authService->withdraw($request);

        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Gửi yêu cầu rút tiền thành công. Vui lòng chờ quản trị viên xác nhận.'),
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => __('notifyFail'),
            ], 400);
        }
    }
}
