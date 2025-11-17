<?php

namespace App\Http\Controllers\Partner\Home;

use App\Admin\Http\Controllers\BaseController;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Admin\Repositories\Slider\SliderRepositoryInterface;

class HomeController extends BaseController
{

    protected SettingRepositoryInterface $settingRepository;

    public function index()
    {
        return to_route('partner.home.index');
    }

}
