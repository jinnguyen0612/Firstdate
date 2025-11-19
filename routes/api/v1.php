<?php

use Illuminate\Support\Facades\Route;

//notification
Route::controller(App\Api\V1\Http\Controllers\Notification\NotificationController::class)
    ->middleware('auth:user')
    ->prefix('/notifications')
    ->as('notification.')
    ->group(function () {
        Route::get('/', 'getUserNotifications')->name('getUserNotifications');
        Route::get('/show/{id}', 'detail')->name('detail');
        Route::get('/read-all', 'updateAllStatusRead')->name('updateAllStatusRead');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::delete('/delete-all', 'deleteAll')->name('deleteAll');
    });

//Price List
Route::controller(App\Api\V1\Http\Controllers\PriceList\PriceListController::class)
    ->prefix('/price-lists')
    ->as('price_list.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

//Package
Route::controller(App\Api\V1\Http\Controllers\Package\PackageController::class)
    ->prefix('/packages')
    ->as('package.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

//App Title
Route::controller(App\Api\V1\Http\Controllers\AppTitle\AppTitleController::class)
    ->prefix('/app-titles')
    ->as('app_titles.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/get', 'getAppTitle')->name('getAppTitle');
    });

//App Video Title
Route::controller(App\Api\V1\Http\Controllers\AppTitleVideo\AppTitleVideoController::class)
    ->prefix('/app-title-videos')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/get', 'getAppTitle')->name('getAppTitle');
    });

//***** -- terms & policies -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Setting\SettingController::class)->prefix('/policies')
    ->group(function () {
        Route::get('/', 'policy')->name('policy'); // Route xuất ra chính sách bảo mật
    });

//***** -- about us -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Setting\SettingController::class)->prefix('/about-us')
    ->group(function () {
        Route::get('/', 'aboutUs')->name('aboutUs'); // Route xuất ra chính sách bảo mật
    });

Route::controller(App\Api\V1\Http\Controllers\Setting\SettingController::class)->prefix('/contact')
    ->group(function () {
        Route::get('/', 'contact')->name('contact'); // Route xuất ra chính sách bảo mật
    });




//***** -- Area -- ******* //
Route::prefix('/areas')
    ->as('area.')
    ->group(function () {
        Route::get('/province', [App\Api\V1\Http\Controllers\Province\ProvinceController::class, 'index'])->name('index'); // Route xuất ra danh sách các
        Route::get('/district', [App\Api\V1\Http\Controllers\District\DistrictController::class, 'index'])->name('index'); // Route xuất ra danh sách các
    });

//***** -- information -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Information\InformationController::class)
    ->prefix('/informations')
    ->as('information.')
    ->group(function () {
        Route::get('/zodiac-sign', 'zodiacSign')->name('zodiac_sign');
        Route::get('/looking-for', 'lookingFor')->name('looking_for');
        Route::get('/relationship', 'relationship')->name('relationship');
        Route::get('/dating-time', 'datingTime')->name('dating_time');
    });
Route::controller(App\Api\V1\Http\Controllers\Bank\BankController::class)
    ->prefix('/banks')
    ->as('bank.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
    });

//Question
Route::controller(App\Api\V1\Http\Controllers\Question\QuestionController::class)
    ->prefix('/questions')
    ->as('question.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });

//slider
Route::controller(App\Api\V1\Http\Controllers\Slider\SliderController::class)
    ->prefix('/sliders')
    ->group(function () {
        Route::get('/show/{key}', 'show')->name('show');
    });

//slider
Route::controller(App\Api\V1\Http\Controllers\Setting\SettingController::class)
    ->prefix('/settings')
    ->group(function () {
        Route::get('', 'index')->name('index');
    });

//users
Route::controller(App\Api\V1\Http\Controllers\User\UserController::class)
    ->prefix('/users')
    ->as('user.')
    ->group(function () {
        Route::group(['middleware' => 'auth:user'], function () {
            Route::post('/register-info', 'draftUpdate')->name('registerInfo');
            Route::get('/profile/{id?}', 'show')->name('show');
            Route::get('/logout', 'logout')->name('logout');
            Route::post('/update', 'update')->name('update');
            Route::post('/update-bank', 'updateBank')->name('updateBank');
            Route::post('/update-pin', 'updatePin')->name('updatePin');
            Route::post('/verify-pin', 'verifyPin')->name('verifyPin');
            Route::get('/near-by', 'getUserNearBy')->name('getUserNearBy');
            Route::post('/register-package', 'registerPackage')->name('registerPackage');
        });
        Route::post('/send-otp', 'sendOTP')->name('sendOTP');
        Route::post('/send-otp-register', 'sendOTPRegister')->name('sendOTPRegister');
        Route::post('/verify-otp', 'verifyOTP')->name('verifyOTP');
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::post('/refresh-token', 'refresh')->name('refresh');
    });

Route::controller(App\Api\V1\Http\Controllers\Transaction\TransactionController::class)
    ->prefix('/transactions')
    ->as('transaction.')
    ->middleware('auth:user')
    ->group(function () {
        Route::post('/top-up-wallet', 'topUpWallet')->name('topUpWallet');
        Route::get('/cancel', 'cancel')->name('cancel');
        Route::post('/withdraw', 'withdraw')->name('withdraw');
    });

Route::controller(App\Api\V1\Http\Controllers\PayOS\PayOSController::class)
    ->prefix('/payos')
    ->as('payos.')
    ->middleware('auth:user')
    ->group(function () {
        Route::post('/webhook', 'webhook')->name('webhook');
    });

//***** -- matching -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Matching\MatchingController::class)
    ->prefix('/matchings')
    ->as('matching.')
    ->middleware('auth:user')
    ->group(function () {
        Route::get('/like-list', 'index')->name('index'); // Route xuất ra danh sách hồ sơ đã thích mình
        Route::post('/add', 'add')->name('add'); // Route chọn thích hồ sơ
        Route::delete('/delete', 'delete')->name('delete'); // Route chọn từ chối
        Route::get('/success', 'matchingSuccess')->name('matchingSuccess'); // Route danh sách hồ sơ ghép đôi thành công
    });

//***** -- Deal -- ******* //
Route::controller(App\Api\V1\Http\Controllers\Deal\DealController::class)
    ->prefix('/deals')
    ->as('deal.')
    ->middleware('auth:user')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/cancel', 'cancel')->name('cancel');
        Route::group(['prefix' => '/district'], function () {
            Route::post('/choose-many', 'chooseDistrictOptions')->name('chooseDistrictOptions');
            Route::get('/select/{id}', 'chooseDistrictFromOptions')->name('chooseDistrictFromOptions');
        });
        Route::group(['prefix' => '/date'], function () {
            Route::post('/choose-many', 'chooseDateOptions')->name('chooseDateOptions');
            Route::get('/select/{id}', 'chooseDateFromOptions')->name('chooseDateFromOptions');
        });
        Route::group(['prefix' => '/partner'], function () {
            Route::post('/choose-many', 'choosePartnerOptions')->name('choosePartnerOptions');
            Route::get('/select/{id}', 'choosePartnerFromOptions')->name('choosePartnerFromOptions');
        });
    });
Route::controller(App\Api\V1\Http\Controllers\Booking\BookingController::class)
    ->prefix('/deals')
    ->as('deal.')
    ->middleware('auth:user')
    ->group(function () {
        Route::get('/pay-deposit/{id}', 'payDeposit')->name('payDeposit');
    });

Route::controller(App\Api\V1\Http\Controllers\Partner\PartnerController::class)
    ->prefix('/partners')
    ->as('partner.')
    ->group(function () {
        Route::get('/', 'index')->name('get');
    });

Route::controller(App\Api\V1\Http\Controllers\SupportCategory\SupportCategoryController::class)
    ->prefix('/support-categories')
    ->as('supportCategory.')
    ->group(function () {
        Route::get('/', 'index')->name('get');
    });

Route::controller(App\Api\V1\Http\Controllers\Support\SupportController::class)
    ->prefix('/supports')
    ->as('support.')
    ->group(function () {
        Route::get('/', 'index')->name('get');
        Route::get('/show/{id}', 'show')->name('show');
    });

Route::fallback(function () {
    return response()->json([
        'status' => 404,
        'message' => __('Không tìm thấy đường dẫn.')
    ], 404);
});
