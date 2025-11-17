<?php

namespace App\Admin\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Admin\Http\Requests\Auth\ProfileRequest;
// use App\Admin\Repositories\CommissionWithdrawal\CommissionWithdrawalRepositoryInterface;
// use App\Admin\Repositories\Order\OrderDetailRepositoryInterface;
use App\Admin\Services\File\FileService;
use App\Admin\Support\Breadcrumb\Breadcrumb;
use App\Admin\Traits\Setup;
use App\Enums\User\Gender;
use App\Mail\Authentication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    use Setup;
    protected Breadcrumb $crums;
    protected FileService $fileService;
    // protected OrderDetailRepositoryInterface $orderDetailRepository;
    // protected CommissionWithdrawalRepositoryInterface $commissionWithdrawalRepository;

    public function __construct(
        // OrderDetailRepositoryInterface $orderDetailRepository,
        // CommissionWithdrawalRepositoryInterface $commissionWithdrawalRepository,
        FileService $fileService
    ) {
        parent::__construct();
        $this->crums = (new Breadcrumb())->add(__('Dashboard'), route('admin.dashboard'));
        $this->fileService = $fileService;
        // $this->orderDetailRepository = $orderDetailRepository;
        // $this->commissionWithdrawalRepository = $commissionWithdrawalRepository;
    }

    public function getView()
    {
        return [
            'index' => 'admin.auth.profile.index',
            'indexUser' => 'user.auth.profile'
        ];
    }
    public function index()
    {
        $auth = auth('admin')->user();
        $gender = Gender::asSelectArray();
        return view($this->view['index'], [
            'auth' => $auth,
            'gender' => $gender
        ]);
    }

    public function indexUser()
    {

        $auth = auth('web')->user();
        $gender = Gender::asSelectArray();
        $breadcrumbs = $this->crums->add(__('Tài khoản'))->getBreadcrumbs();

        return view($this->view['indexUser'], compact('auth', 'gender', 'breadcrumbs'));
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            if (isset($data['avatar'])) {
                $data['avatar'] = $this->fileService->uploadAvatar('images', $data['avatar'], null);
            }
            if (auth('admin')->check()) {
                auth('admin')->user()->update($data);
            } elseif (auth('web')->check()) {
                $user = auth('web')->user();
                $oldEmail = $user->email;

                // Kiểm tra nếu email thay đổi
                if (isset($data['email']) && $data['email'] !== $user->email) {
                    $data['active'] = 0; // Đặt lại trạng thái active
                    $data['token_active_account'] = random_int(1000, 9999); // Tạo token mới
                    $data['token_expiration'] = Carbon::now()->addMinutes(30);

                    // Gửi email kích hoạt tài khoản
                    Mail::to($data['email'])->send(new Authentication([
                        'fullname' => $user->fullname,
                        'token_active_account' => $data['token_active_account'],
                        'email' => $data['email'], // Email mới
                    ]));
                }
                if (!isset($data['is_checked'])) {
                    $data['is_checked'] = 0;
                }
                if (isset($data['bank_name']) && !$user->affiliate_code && isset($data['is_checked']) && $data['is_checked'] == 1) {
                    $data['affiliate_code'] = $this->createAffiliateCode();
                }

                // Cập nhật thông tin người dùng
                $user->update($data);
                if (isset($data['email']) && $data['email'] !== $oldEmail) {
                    DB::commit();
                    Auth::guard('web')->logout();
                    return redirect()->intended(route('user.auth.oauth', ['code' => $data['code']]))->with('success', __('Bạn vừa thay đổi email, hãy kiểm tra hòm thư để kích hoạt tài khoản.'));
                }
            }
            DB::commit();
            return back()->with('success', __('notifySuccess'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', __('notifyError'));
        }
    }
}
