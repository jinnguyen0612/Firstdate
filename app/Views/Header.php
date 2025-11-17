<?php

namespace App\Views;

use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\View\Component;
use App\Admin\Traits\GetConfig;

use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Enums\Setting\SettingGroup;

class Header extends Component
{
    use GetConfig;

    protected SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getCategoriesWithChildren($categories)
    {
        foreach ($categories as $category) {
            if (!$category->relationLoaded('children')) {
                $category->load('children');
            }
            $this->getCategoriesWithChildren($category->children);
        }

        return $categories;
    }

    public function render()
    {
        $settings = $this->settingRepository->getAll();
        return view('components.layouts.header', compact('settings'));
    }
}
