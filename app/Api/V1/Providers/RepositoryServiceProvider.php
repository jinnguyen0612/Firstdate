<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        'App\Api\V1\Repositories\Slider\SliderRepositoryInterface' => 'App\Api\V1\Repositories\Slider\SliderRepository',
        'App\Api\V1\Repositories\Slider\SliderItemRepositoryInterface' => 'App\Api\V1\Repositories\Slider\SliderItemRepository',
        'App\Api\V1\Repositories\Review\ReviewRepositoryInterface' => 'App\Api\V1\Repositories\Review\ReviewRepository',
        'App\Api\V1\Repositories\Notification\NotificationRepositoryInterface' => 'App\Api\V1\Repositories\Notification\NotificationRepository',
        'App\Api\V1\Repositories\Requests\RequestsRepositoryInterface' => 'App\Api\V1\Repositories\Requests\RequestsRepository',
        'App\Api\V1\Repositories\UserNotification\UserNotificationRepositoryInterface' => 'App\Api\V1\Repositories\UserNotification\UserNotificationRepository',

        'App\Api\V1\Repositories\District\DistrictRepositoryInterface' => 'App\Api\V1\Repositories\District\DistrictRepository',
        'App\Api\V1\Repositories\Province\ProvinceRepositoryInterface' => 'App\Api\V1\Repositories\Province\ProvinceRepository',
        'App\Api\V1\Repositories\Otp\OtpRepositoryInterface' => 'App\Api\V1\Repositories\Otp\OtpRepository',
        'App\Api\V1\Repositories\User\UserRepositoryInterface' => 'App\Api\V1\Repositories\User\UserRepository',
        'App\Api\V1\Repositories\AppTitle\AppTitleRepositoryInterface' => 'App\Api\V1\Repositories\AppTitle\AppTitleRepository',
        'App\Api\V1\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface' => 'App\Api\V1\Repositories\AppTitleVideo\AppTitleVideoRepository',
        'App\Api\V1\Repositories\Question\QuestionRepositoryInterface' => 'App\Api\V1\Repositories\Question\QuestionRepository',
        'App\Api\V1\Repositories\Answer\AnswerRepositoryInterface' => 'App\Api\V1\Repositories\Answer\AnswerRepository',
        'App\Api\V1\Repositories\UserAnswer\UserAnswerRepositoryInterface' => 'App\Api\V1\Repositories\UserAnswer\UserAnswerRepository',
        'App\Api\V1\Repositories\Matching\MatchingRepositoryInterface' => 'App\Api\V1\Repositories\Matching\MatchingRepository',
        'App\Api\V1\Repositories\Deal\DealRepositoryInterface' => 'App\Api\V1\Repositories\Deal\DealRepository',
        'App\Api\V1\Repositories\Booking\BookingRepositoryInterface' => 'App\Api\V1\Repositories\Booking\BookingRepository',
        'App\Api\V1\Repositories\SupportCategory\SupportCategoryRepositoryInterface' => 'App\Api\V1\Repositories\SupportCategory\SupportCategoryRepository',
        'App\Api\V1\Repositories\Support\SupportRepositoryInterface' => 'App\Api\V1\Repositories\Support\SupportRepository',
        'App\Api\V1\Repositories\Bank\BankRepositoryInterface' => 'App\Api\V1\Repositories\Bank\BankRepository',
        'App\Api\V1\Repositories\Partner\PartnerRepositoryInterface' => 'App\Api\V1\Repositories\Partner\PartnerRepository',
        'App\Api\V1\Repositories\PriceList\PriceListRepositoryInterface' => 'App\Api\V1\Repositories\PriceList\PriceListRepository',
        'App\Api\V1\Repositories\Package\PackageRepositoryInterface' => 'App\Api\V1\Repositories\Package\PackageRepository',
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
