<?php

namespace App\Http\Controllers\Partner\Auth;

use App\Admin\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        SliderRepositoryInterface $sliderRepository
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
        $this->sliderRepository = $sliderRepository;
    }
    public function getView()
    {
        return [
            'index' => 'partner.auth.login',
            'forgotPassword' => 'partner.auth.forgot_password',
            'verify' => 'partner.auth.verify',
            'change_forgot_password' => 'partner.auth.change_forgot_password',
        ];
    }
    public function home()
    {
        $settings = $this->settingRepository->getAll();
        return view($this->view['index'], [
            'settings' => $settings,
        ]);
    }

    public function login(LoginRequest $request)
    {
        try {
            $this->login = $request->validated();

            Auth::guard('admin')->logout();

            $attempt = $this->resolveSubAdmin();
            if ($attempt) {
                $request->session()->regenerate();
                return $this->handleSubAdminLogin();
            }

            return back()->with('error', __('Email hoặc mật khẩu không đúng'));
        } catch (\Throwable $th) {
            Log::error('Error login: ' . $th->getMessage());
            return back()->with('error', __('Đã có lỗi xảy ra'));
        }
    }


    public function forgotPassword()
    {
        $settings = $this->settingRepository->getAll();
        return view($this->view['forgotPassword'], [
            'settings' => $settings,
        ]);
    }

    public function verify()
    {
        $settings = $this->settingRepository->getAll();
        return view($this->view['verify'], [
            'settings' => $settings,
        ]);
    }

    public function changeForgotPassword()
    {
        $settings = $this->settingRepository->getAll();
        return view($this->view['change_forgot_password'], [
            'settings' => $settings,
        ]);
    }


    protected function handlePartnerLogin()
    {
        if (Auth::guard('partner')->check()) {
            return redirect()->intended(route('partner.home.index'))->with('success', __('Đăng nhập thành công'));
        }
    }

    protected function handleSubAdminLogin()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $admin = Auth::guard('admin')->user();

        if ($admin->hasRole('subAdmin')) {
            return redirect()->intended(route('partner.home.index'))
                ->with('success', __('Đăng nhập thành công'));
        }

        Auth::guard('admin')->logout();
        return back()->with('error', __('Bạn không có quyền Sub Admin'));
    }

    protected function resolvePartner()
    {
        return Auth::guard('partner')->attempt([
            'email' => $this->login['email'],
            'password' => $this->login['password'],
        ], true);
    }

    protected function resolveSubAdmin()
    {
        return Auth::guard('admin')->attempt([
            'email' => $this->login['email'],
            'password' => $this->login['password'],
        ], true);
    }
}
