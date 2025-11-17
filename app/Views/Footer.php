<?php

namespace App\Views;

use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\View\Component;
use App\Admin\Traits\GetConfig;

use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Setting\SettingGroup;

class Footer extends Component
{
    use GetConfig;

    protected SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function render()
    {
        return view('components.layouts.footer');
    }
}
