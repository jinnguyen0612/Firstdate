<?php

namespace App\Admin\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected array $services = [
        'App\Admin\Services\CategorySystem\CategorySystemServiceInterface' => 'App\Admin\Services\CategorySystem\CategorySystemService',
        'App\Admin\Services\Module\ModuleServiceInterface' => 'App\Admin\Services\Module\ModuleService',
        'App\Admin\Services\Permission\PermissionServiceInterface' => 'App\Admin\Services\Permission\PermissionService',
        'App\Admin\Services\Role\RoleServiceInterface' => 'App\Admin\Services\Role\RoleService',
        'App\Admin\Services\Admin\AdminServiceInterface' => 'App\Admin\Services\Admin\AdminService',
        'App\Admin\Services\User\UserServiceInterface' => 'App\Admin\Services\User\UserService',
        'App\Admin\Services\Category\CategoryServiceInterface' => 'App\Admin\Services\Category\CategoryService',
        'App\Admin\Services\Notification\NotificationServiceInterface' => 'App\Admin\Services\Notification\NotificationService',
        'App\Admin\Services\Slider\SliderServiceInterface' => 'App\Admin\Services\Slider\SliderService',
        'App\Admin\Services\Slider\SliderItemServiceInterface' => 'App\Admin\Services\Slider\SliderItemService',
        'App\Admin\Services\PartnerCategory\PartnerCategoryServiceInterface' => 'App\Admin\Services\PartnerCategory\PartnerCategoryService',
        'App\Admin\Services\Partner\PartnerServiceInterface' => 'App\Admin\Services\Partner\PartnerService',
        'App\Admin\Services\Question\QuestionServiceInterface' => 'App\Admin\Services\Question\QuestionService',
        'App\Admin\Services\Booking\BookingServiceInterface' => 'App\Admin\Services\Booking\BookingService',
        'App\Admin\Services\AppTitle\AppTitleServiceInterface' => 'App\Admin\Services\AppTitle\AppTitleService',
        'App\Admin\Services\AppTitleVideo\AppTitleVideoServiceInterface' => 'App\Admin\Services\AppTitleVideo\AppTitleVideoService',
        'App\Admin\Services\PriceList\PriceListServiceInterface' => 'App\Admin\Services\PriceList\PriceListService',
        'App\Admin\Services\Transaction\TransactionServiceInterface' => 'App\Admin\Services\Transaction\TransactionService',
        'App\Admin\Services\RejectReason\RejectReasonServiceInterface' => 'App\Admin\Services\RejectReason\RejectReasonService',
        'App\Admin\Services\PartnerTable\PartnerTableServiceInterface' => 'App\Admin\Services\PartnerTable\PartnerTableService',
        'App\Admin\Services\SupportCategory\SupportCategoryServiceInterface' => 'App\Admin\Services\SupportCategory\SupportCategoryService',
        'App\Admin\Services\Support\SupportServiceInterface' => 'App\Admin\Services\Support\SupportService',
        'App\Admin\Services\Package\PackageServiceInterface' => 'App\Admin\Services\Package\PackageService',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
        foreach ($this->services as $interface => $implement) {
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
