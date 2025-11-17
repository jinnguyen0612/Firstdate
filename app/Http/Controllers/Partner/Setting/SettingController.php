<?php

namespace App\Http\Controllers\Partner\Setting;

use App\Admin\Http\Requests\Auth\LoginRequest;
use App\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;
use App\Admin\Traits\AuthService;
use App\Enums\Setting\SettingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    use AuthService;
    private $login;

    protected SettingRepositoryInterface $settingRepository;
    protected SliderRepositoryInterface $sliderRepository;
    public function __construct(
        SettingRepositoryInterface $settingRepository,
        SliderRepositoryInterface $sliderRepository,
    ) {
        parent::__construct();
        $this->settingRepository = $settingRepository;
        $this->sliderRepository = $sliderRepository;
    }
    public function getView()
    {
        return [
            'index' => 'partner.setting.index',
        ];
    }

    public function index()
    {
        $settings = $this->settingRepository->getAll();
        $policy = $this->settingRepository->findByField('setting_key', 'policy');  

        return view($this->view['index'], [
            'settings' => $settings,
            'title' => 'Thông tin chính sách',
            'policy' => $policy->plain_value
        ]);
    }
   
}
