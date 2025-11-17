<?php

namespace App\Api\V1\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    protected $services = [
        'App\Api\V1\Services\Auth\AuthServiceInterface' => 'App\Api\V1\Services\Auth\AuthService',
        'App\Api\V1\Services\Requests\RequestsServiceInterface' => 'App\Api\V1\Services\Requests\RequestsService',
        'App\Api\V1\Services\Notification\NotificationServiceInterface' => 'App\Api\V1\Services\Notification\NotificationService',
        'App\Api\V1\Services\UserNotification\UserNotificationServiceInterface' => 'App\Api\V1\Services\UserNotification\UserNotificationService',
        'App\Api\V1\Services\Session\SessionServiceInterface' => 'App\Api\V1\Services\Session\SessionService',
        'App\Api\V1\Services\Reschedule\RescheduleServiceInterface' => 'App\Api\V1\Services\Reschedule\RescheduleService',
        'App\Api\V1\Services\Matching\MatchingServiceInterface' => 'App\Api\V1\Services\Matching\MatchingService',
        'App\Api\V1\Services\Deal\DealServiceInterface' => 'App\Api\V1\Services\Deal\DealService',
        'App\Api\V1\Services\Booking\BookingServiceInterface' => 'App\Api\V1\Services\Booking\BookingService',
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
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
