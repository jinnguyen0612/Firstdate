<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Admin\Repositories\CategorySystem\CategorySystemRepositoryInterface' => 'App\Admin\Repositories\CategorySystem\CategorySystemRepository',
        'App\Admin\Repositories\Module\ModuleRepositoryInterface' => 'App\Admin\Repositories\Module\ModuleRepository',
        'App\Admin\Repositories\Permission\PermissionRepositoryInterface' => 'App\Admin\Repositories\Permission\PermissionRepository',
        'App\Admin\Repositories\Role\RoleRepositoryInterface' => 'App\Admin\Repositories\Role\RoleRepository',
        'App\Admin\Repositories\Admin\AdminRepositoryInterface' => 'App\Admin\Repositories\Admin\AdminRepository',
        'App\Admin\Repositories\User\UserRepositoryInterface' => 'App\Admin\Repositories\User\UserRepository',
        'App\Admin\Repositories\Setting\SettingRepositoryInterface' => 'App\Admin\Repositories\Setting\SettingRepository',
        'App\Admin\Repositories\Slider\SliderRepositoryInterface' => 'App\Admin\Repositories\Slider\SliderRepository',
        'App\Admin\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Admin\Repositories\Slider\SliderItemRepository',
        'App\Admin\Repositories\Province\ProvinceRepositoryInterface' => 'App\Admin\Repositories\Province\ProvinceRepository',
        'App\Admin\Repositories\District\DistrictRepositoryInterface' => 'App\Admin\Repositories\District\DistrictRepository',
        'App\Admin\Repositories\Ward\WardRepositoryInterface' => 'App\Admin\Repositories\Ward\WardRepository',
        'App\Admin\Repositories\Icon\IconRepositoryInterface' => 'App\Admin\Repositories\Icon\IconRepository',
        'App\Admin\Repositories\Notification\NotificationRepositoryInterface' => 'App\Admin\Repositories\Notification\NotificationRepository',
        'App\Admin\Repositories\PartnerCategory\PartnerCategoryRepositoryInterface' => 'App\Admin\Repositories\PartnerCategory\PartnerCategoryRepository',
        'App\Admin\Repositories\Partner\PartnerRepositoryInterface' => 'App\Admin\Repositories\Partner\PartnerRepository',
        'App\Admin\Repositories\Question\QuestionRepositoryInterface' => 'App\Admin\Repositories\Question\QuestionRepository',
        'App\Admin\Repositories\Answer\AnswerRepositoryInterface' => 'App\Admin\Repositories\Answer\AnswerRepository',
        'App\Admin\Repositories\Transaction\TransactionRepositoryInterface' => 'App\Admin\Repositories\Transaction\TransactionRepository',
        'App\Admin\Repositories\Booking\BookingRepositoryInterface' => 'App\Admin\Repositories\Booking\BookingRepository',
        'App\Admin\Repositories\Invoice\InvoiceRepositoryInterface' => 'App\Admin\Repositories\Invoice\InvoiceRepository',
        'App\Admin\Repositories\AppTitle\AppTitleRepositoryInterface' => 'App\Admin\Repositories\AppTitle\AppTitleRepository',
        'App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface' => 'App\Admin\Repositories\AppTitleVideo\AppTitleVideoRepository',
        'App\Admin\Repositories\Deal\DealRepositoryInterface' => 'App\Admin\Repositories\Deal\DealRepository',
        'App\Admin\Repositories\ProfileMonthly\ProfileMonthlyRepositoryInterface' => 'App\Admin\Repositories\ProfileMonthly\ProfileMonthlyRepository',
        'App\Admin\Repositories\PriceList\PriceListRepositoryInterface' => 'App\Admin\Repositories\PriceList\PriceListRepository',
        'App\Admin\Repositories\RejectReason\RejectReasonRepositoryInterface' => 'App\Admin\Repositories\RejectReason\RejectReasonRepository',
        'App\Admin\Repositories\PartnerTable\PartnerTableRepositoryInterface' => 'App\Admin\Repositories\PartnerTable\PartnerTableRepository',
        'App\Admin\Repositories\SupportCategory\SupportCategoryRepositoryInterface' => 'App\Admin\Repositories\SupportCategory\SupportCategoryRepository',
        'App\Admin\Repositories\Support\SupportRepositoryInterface' => 'App\Admin\Repositories\Support\SupportRepository',
        'App\Admin\Repositories\Package\PackageRepositoryInterface' => 'App\Admin\Repositories\Package\PackageRepository',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        foreach ($this->repositories as $interface => $implement) {
            $this->app->singleton($interface, $implement);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
