<?php

namespace App\Http\Controllers\Partner\Profile;

use App\Admin\Repositories\District\DistrictRepositoryInterface;
use App\Http\Requests\Partner\Profile\ProfileRequest;
use App\Admin\Repositories\PartnerCategory\PartnerCategoryRepositoryInterface;
use App\Admin\Repositories\PriceList\PriceListRepositoryInterface;
use App\Admin\Repositories\Province\ProvinceRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Repositories\Transaction\TransactionRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Traits\AuthService;
use App\Enums\Transaction\TransactionStatus;
use App\Enums\Transaction\TransactionType;
use App\Http\Requests\Partner\Transaction\DepositRequest;
use App\Http\Requests\Partner\Transaction\TransactionRequest;
use App\Http\Requests\Partner\Transaction\WithdrawRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    use AuthService;
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        SliderRepositoryInterface $sliderRepository,
        protected PriceListRepositoryInterface $priceListRepository,
        protected TransactionRepositoryInterface $transactionRepository,
        protected PartnerCategoryRepositoryInterface $partnerCategoryRepository,
        protected ProvinceRepositoryInterface $provinceRepository,
        protected DistrictRepositoryInterface $districtRepository,
        private FileService $fileService,
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
        $this->sliderRepository = $sliderRepository;
    }
    public function getView()
    {
        return [
            'index' => 'partner.profile.index',
            'account' => 'partner.profile.account',
            'history' => 'partner.profile.transaction-history',
            'transaction' => 'partner.profile.transaction-detail',
            'deposit' => 'partner.profile.deposit',
        ];
    }
    public function index()
    {
        $settings = $this->settingRepository->getAll();
        $currentPartner = $this->getCurrentAdmin();
        $priceList = $this->priceListRepository->getAll();

        return view($this->view['index'], [
            'settings' => $settings,
            'title' => 'Người dùng',
            'currentPartner' => $currentPartner,
            'priceList' => $priceList,
        ]);
    }

    public function account()
    {
        $settings = $this->settingRepository->getAll();
        $currentPartner = $this->getCurrentAdmin();
        $partnerCategories = $this->partnerCategoryRepository->getAll();

        return view($this->view['account'], [
            'settings' => $settings,
            'title' => 'Thông tin tài khoản',
            'currentPartner' => $currentPartner,
            'partnerCategories' => $partnerCategories,
        ]);
    }

    public function updateProfile(ProfileRequest $request)
    {
        $data = $request->validated();
        $currentPartner = $this->getCurrentAdmin();
        try {
            if (isset($data['avatar']) && $data['avatar']) {
                $avatar = $this->fileService->uploadAvatar('partner', $data['avatar']);
                $data['avatar'] = $avatar;
            }

            $province = $this->provinceRepository->getByName($data['province']);
            $data['province_id'] = $province->id;
            unset($data['province']);

            $district = $this->districtRepository->getByName($data['district'], $province->code);
            $data['district_id'] = $district->id;
            unset($data['district']);



            $currentPartner->update($data);

            return response()->json([
                'status' => 200,
                'message' => __('Cập nhật hồ sơ thành công.'),
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại. Hãy kiểm tra lại'),
            ], 400);
        }
    }

    public function updateGallery(Request $request)
    {
        $gallery = $request->get('gallery', null);
        if (is_string($gallery)) {
            $gallery = json_decode($gallery, true);
        }

        if (!is_array($gallery)) {
            $gallery = [];
        }
        $currentPartner = $this->getCurrentAdmin();
        $asset = asset('');
        $data = [];

        try {
            if ($gallery) {
                foreach ($gallery as $item) {
                    if (Str::startsWith($item, 'data:image')) {
                        // Upload ảnh base64
                        $file = $this->base64ToUploadedFile($item);
                        $avatar = $this->fileService->uploadAvatar('partner', $file);
                        Log::info($avatar);
                        $data[] = $avatar;
                    } else {
                        // Ảnh cũ giữ nguyên
                        $data[] = str_replace($asset, '', $item);
                    }
                }
            } else {
                $data = [];
            }
            $currentPartner->update([
                'gallery' => $data
            ]);

            return response()->json([
                'status' => 200,
                'message' => __('Cập nhật thư viện ảnh thành công.'),
            ]);
        } catch (\Throwable $th) {
            Log::error('Error updateGallery: ' . $th->getMessage());

            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại. Hãy kiểm tra lại'),
            ], 400);
        }
    }


    public function transactionHistory()
    {
        $settings = $this->settingRepository->getAll();
        $currentPartner = $this->getCurrentAdmin();
        $transactions = $this->transactionRepository->getTransactionByPartner($currentPartner);
        $total = $this->transactionRepository->countTransactionByPartner($currentPartner);
        $transactions->total = $total;

        return view($this->view['history'], [
            'settings' => $settings,
            'title' => 'Lịch sử giao dịch',
            'transactions' => $transactions,
        ]);
    }

    public function loadPage(Request $request)
    {
        $currentPartner = $this->getCurrentAdmin();

        $transactions = $this->transactionRepository->getTransactionByPartner($currentPartner);
        Log::info($transactions);
        $total = $this->transactionRepository->countTransactionByPartner($currentPartner);
        $transactions->total = $total;

        $html = view('partner.profile.components.laptop-history', [
            'transactions' => $transactions
        ])->render();

        return response()->json([
            'status'       => 'success',
            'html'         => $html,
            'current_page' => $transactions->currentPage(),
            'has_more'    => $transactions->hasMorePages()
        ]);
    }

    public function loadMore(Request $request)
    {
        $currentPartner = $this->getCurrentAdmin();

        $transactions = $this->transactionRepository->getTransactionByPartner($currentPartner);

        $html = view('partner.profile.components.mobile-history', [
            'transactions' => $transactions
        ])->render();

        return response()->json([
            'status'       => 'success',
            'html'         => $html,
            'current_page' => $transactions->currentPage(),
            'has_more'    => $transactions->hasMorePages()
        ]);
    }

    public function transactionDetail($code)
    {
        $settings = $this->settingRepository->getAll();
        $currentPartnerId = $this->getCurrentAdminId();

        $transaction = $this->transactionRepository->findByField('code', $code);

        if (!$transaction || (($transaction->from_type != Partner::class || $transaction->from_id != $currentPartnerId) &&
            ($transaction->to_type != Partner::class || $transaction->to_id != $currentPartnerId))) {
            abort(404);
        }

        return view($this->view['transaction'], [
            'settings' => $settings,
            'title' => 'Chi tiết giao dịch',
            'transaction' => $transaction
        ]);
    }

    public function deposit(Request $request)
    {
        $settings = $this->settingRepository->getAll();
        $currentPartnerId = $this->getCurrentAdminId();

        $amount = $request->get('amount');

        return view($this->view['deposit'], [
            'settings' => $settings,
            'title' => 'Nạp tiền',
            'amount' => $amount
        ]);
    }

    public function sendDeposit(DepositRequest $request)
    {
        $data = $request->validated();
        $currentPartner = $this->getCurrentAdmin();

        try {
            if (isset($data['image']) && $data['image']) {
                $bill = $this->fileService->uploadAvatar('/topup', $data['image']);
                $data['image'] = $bill;
            }

            $transaction = $this->transactionRepository->createTransaction(
                $currentPartner,
                null,
                $data['amount'],
                TransactionType::Deposit->value,
                TransactionStatus::Pending->value,
                $data['image'] ?? null,
                $data['description']
            );

            return response()->json([
                'status' => 200,
                'message' => __('Nạp tiền thành công.'),
                'transaction' => $transaction
            ]);
        } catch (\Throwable $th) {
            Log::error('Error deposit: ' . $th->getMessage());

            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại. Hãy kiểm tra lại'),
            ], 400);
        }
    }

    public function sendWithdraw(WithdrawRequest $request)
    {
        $data = $request->validated();
        $currentPartner = $this->getCurrentAdmin();

        try {

            $transaction = $this->transactionRepository->createTransaction(
                $currentPartner,
                null,
                $data['amount'],
                TransactionType::Withdraw->value,
                TransactionStatus::Pending->value,
                null,
                $data['description']
            );

            $currentPartner->decrement('wallet', $data['amount']);

            return response()->json([
                'status' => 200,
                'message' => __('Rút tiền thành công.'),
                'transaction' => $transaction
            ]);
        } catch (\Throwable $th) {
            Log::error('Error withdraw: ' . $th->getMessage());

            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại. Hãy kiểm tra lại'),
            ], 400);
        }
    }


    private function base64ToUploadedFile(string $base64, ?string $filename = null): UploadedFile
    {
        // Tách phần MIME và data
        @list($type, $fileData) = explode(';', $base64);
        @list(, $fileData) = explode(',', $fileData);

        // Giải mã dữ liệu base64
        $fileData = base64_decode($fileData);

        // Lấy extension từ MIME
        $mime = explode(':', str_replace(';', '', $type))[1] ?? 'application/octet-stream';
        $extension = explode('/', $mime)[1] ?? 'bin';

        // Tạo tên file
        $filename = $filename ?? Str::random(10) . '.' . $extension;

        // Tạo file tạm
        $tmpFilePath = sys_get_temp_dir() . '/' . $filename;
        file_put_contents($tmpFilePath, $fileData);

        // Trả về UploadedFile
        return new UploadedFile(
            $tmpFilePath,
            $filename,
            $mime,
            null,
            true
        );
    }
}
