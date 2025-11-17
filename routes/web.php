<?php

use App\Admin\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Partner\Home\HomeController;
use App\Http\Controllers\Partner\Auth\AuthController;
use App\Http\Controllers\Partner\Booking\BookingController;
use App\Http\Controllers\Partner\Checkin\CheckinController;
use App\Http\Controllers\Partner\Notification\NotificationController;
use App\Http\Controllers\Partner\Profile\ProfileController;
use App\Http\Controllers\Partner\Setting\SettingController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)
    ->middleware('guest:partner')
    ->prefix('/login')
    ->group(function () {
        Route::get('/', 'home')->name('login');
        Route::post('/', 'login')->name('login.submit');
    });

Route::controller(LogoutController::class)
    ->middleware('admin.auth.partner:admin')
    ->prefix('/logout')
    ->group(function () {
        Route::get('/', 'logout')->name('logout');
    });

Route::controller(AuthController::class)
    ->middleware('guest:partner')
    ->prefix('/auth')
    ->group(function () {
        Route::get('/forgot-password', 'forgotPassword')->name('forgotPasswordView');
        Route::get('/change-forgot-password', 'changeForgotPassword')->name('changeForgotPasswordView');
        Route::get('/verify', 'verify')->name('verifyView');
    });

Route::controller(CheckinController::class)
    ->middleware('guest:partner')
    ->prefix('/checkin')
    ->group(function () {
        Route::get('/{code}/staff/login', 'staffLoginView')->name('checkin.login');
        Route::post('/staff/login', 'staffLogin')->name('checkin.staffLogin');
    });


Route::controller(CheckinController::class)
    ->middleware('admin.auth.staff:partner')
    ->prefix('/checkin')
    ->group(function () {
        Route::get('/{code}/staff/{bookingCode}', 'staffDetail')->name('staffDetail');
        Route::get('/{code}/staff', 'staff')->name('staff');
    });

Route::controller(CheckinController::class)
    ->middleware('guest:partner')
    ->prefix('/checkin')
    ->group(function () {
        Route::get('/{code}', 'index')->name('checkin');
        Route::get('/{bookingCode}/{userCode}', 'userCheckin')->name('userCheckin');
        Route::post('/{bookingCode}/{userCode}', 'sendUserCheckin')->name('send-checkin');
        Route::post('/completed', 'completed')->name('checkin.completed');
    });



Route::controller(BookingController::class)
    ->middleware('admin.auth.partner:admin')
    ->group(function () {
        Route::get('/', 'home')->name('home.index');
        Route::get('/booking/{code}', 'detail')->name('booking.detail');
        Route::post('/booking/reject', 'reject')->name('booking.reject');
        Route::post('/booking/accept', 'accept')->name('booking.accept');
        Route::post('/booking/accept-cancel', 'acceptCancel')->name('booking.acceptCancel');
        Route::get('/booking/to-processing/{id}', 'toProcessing')->name('booking.toProcessing');
        Route::post('/booking/completed', 'completed')->name('booking.completed');

        Route::get('/ajax/booking/filter-new', 'ajaxNewBooking')->name('booking.filterNew');
        Route::get('/ajax/booking/filter-confirmed', 'ajaxConfirmBooking')->name('booking.filterConfirm');
    });

Route::controller(NotificationController::class)
    ->middleware('admin.auth.partner:admin')
    ->as('notification.')
    ->prefix('/notification')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/load-page', 'loadPage')->name('loadPage');
        Route::get('/load-more', 'loadMore')->name('loadMore');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/read-all', 'readAll')->name('readAll');
        Route::post('/delete-read', 'deleteRead')->name('deleteRead');
        Route::post('/multiple-action', 'multipleAction')->name('multipleAction');
    });

Route::controller(ProfileController::class)
    ->middleware('admin.auth.partner:admin')
    ->as('profile.')
    ->prefix('/profile')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/account', 'account')->name('account');
        Route::post('/update-profile', 'updateProfile')->name('updateProfile');
        Route::post('/update-gallery', 'updateGallery')->name('updateGallery');
    });

Route::controller(ProfileController::class)
    ->middleware('admin.auth.partner:admin')
    ->as('profile.')
    ->group(function () {
        Route::get('/transaction-history', 'transactionHistory')->name('transactions');
        Route::get('/transaction/{code}', 'transactionDetail')->name('transaction.detail');
        Route::get('/load-page', 'loadPage')->name('transaction.loadPage');
        Route::get('/load-more', 'loadMore')->name('transaction.loadMore');
        Route::get('/deposit', 'deposit')->name('deposit');
        Route::post('/send-deposit', 'sendDeposit')->name('sendDeposit');
        Route::post('/send-withdraw', 'sendWithdraw')->name('sendWithdraw');
    });

Route::controller(SettingController::class)
    ->middleware('admin.auth.partner:admin')
    ->as('setting.')
    ->group(function () {
        Route::get('/policy', 'index')->name('policy');
    });

Route::prefix('/search')->as('search.')->group(function () {
    Route::prefix('/select')->as('select.')->group(function () {
        Route::get('/partner-category', [App\Http\Controllers\Partner\PartnerCategory\PartnerCategorySearchSelectController::class, 'selectSearch'])->name('partner_category');
    });
});
