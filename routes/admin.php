<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Admin\Http\Controllers\Home\HomeController::class, 'index']);

// login
Route::controller(App\Admin\Http\Controllers\Auth\LoginController::class)
    ->middleware('guest:admin')
    ->prefix('/login')
    ->as('login.')
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/not-found', 'notfound')->name('notfound');
        Route::post('/', 'login')->name('post');
    });

Route::get('test/generate-deal/{count?}', function ($count = 1) {
    Artisan::call('deals:generate', ['count' => $count]);
    return "Đã tạo {$count} deal giả lập";
});

Route::group(['middleware' => 'admin.auth.admin:admin'], function () {
    //Notification
    Route::prefix('/notifications')->as('notification.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Notification\NotificationController::class)->group(function () {
            Route::group(['middleware' => ['permission:createNotification', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewNotification', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/admin', 'getAllNotificationAdmin')->name('getAllNotificationAdmin');
                Route::post('/update-device-token', 'updateDeviceToken')->name('updateDeviceToken');
                Route::get('/sua/{id}', 'edit')->name('edit');
                Route::get('/show/{id}', 'show')->name('show');
                Route::get('/read-all', 'readAllNotification')->name('readAllNotification');
            });

            Route::group(['middleware' => ['permission:updateNotification', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteNotification', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
                Route::post('/xu-ly-nhieu-ban-ghi', 'actionMultipleRecord')->name('multiple');
            });
        });
    });

    //admin
    Route::prefix('/admins')->as('admin.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Admin\AdminController::class)->group(function () {
            Route::group(['middleware' => ['permission:createAdmin', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewAdmin', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateAdmin', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteAdmin', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //role
    Route::prefix('/role')->as('role.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Role\RoleController::class)->group(function () {

            Route::group(['middleware' => ['permission:createRole', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewRole', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateRole', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteRole', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //Price List
    Route::prefix('/price-list')->as('price_list.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\PriceList\PriceListController::class)->group(function () {
            Route::group(['middleware' => ['permission:createPriceList', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewPriceList', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updatePriceList', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deletePriceList', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //App Title
    Route::prefix('/reject-reason')->as('reject_reason.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\RejectReason\RejectReasonController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewAppTitle', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
            });

            Route::group(['middleware' => ['permission:updateAppTitle', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
        });
    });

    //App Title
    Route::prefix('/app-title')->as('app_title.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\AppTitle\AppTitleController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewAppTitle', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
            });

            Route::group(['middleware' => ['permission:updateAppTitle', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
        });
    });

    //App Title Video
    Route::prefix('/app-title-video')->as('app_title_video.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\AppTitleVideo\AppTitleVideoController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewAppTitle', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
            });

            Route::group(['middleware' => ['permission:updateAppTitle', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
        });
    });


    Route::controller(App\Admin\Http\Controllers\Setting\SettingController::class)
        ->prefix('/settings')
        ->as('setting.')
        ->group(function () {
            Route::group(['middleware' => ['permission:settingGeneral', 'auth:admin']], function () {
                Route::get('/general', 'general')->name('general');
                Route::get('/payment', 'payment')->name('payment');
                Route::get('/footer', 'footer')->name('footer');
                Route::get('/contact', 'contact')->name('contact');
                Route::get('/information', 'information')->name('information');
                Route::get('/theme', 'theme')->name('theme');
                Route::get('/config', 'config')->name('config');
                Route::get('/zalo-miniapp-config', 'zaloMiniAppConfig')->name('zaloMiniAppConfig');
            });
            Route::put('/update', 'update')->name('update');
        });

    Route::prefix('/sliders')->as('slider.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Slider\SliderItemController::class)
            ->as('item.')
            ->group(function () {
                Route::get('/{slider_id}/item/them', 'create')->name('create');
                Route::get('/{slider_id}/item', 'index')->name('index');
                Route::get('/item/sua/{id}', 'edit')->name('edit');
                Route::put('/item/sua', 'update')->name('update');
                Route::post('/item/them', 'store')->name('store');
                Route::delete('/{slider_id}/item/xoa/{id}', 'delete')->name('delete');
            });
        Route::controller(App\Admin\Http\Controllers\Slider\SliderController::class)->group(function () {
            Route::group(['middleware' => ['permission:createSlider', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewSlider', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateSlider', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteSlider', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });
    //user
    Route::prefix('/users')->as('user.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\User\UserController::class)->group(function () {
            Route::group(['middleware' => ['permission:createUser', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewUser', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateUser', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteUser', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //support category
    Route::prefix('/support-categories')->group(function () {
        Route::controller(App\Admin\Http\Controllers\SupportCategory\SupportCategoryController::class)->as('support_category.')->group(function () {
            Route::group(['middleware' => ['permission:createSupportCategory', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewSupportCategory', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateSupportCategory', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteSupportCategory', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
        Route::controller(App\Admin\Http\Controllers\Support\SupportController::class)->as('support.')->group(function () {
            Route::group(['middleware' => ['permission:createSupport', 'auth:admin']], function () {
                Route::get('/{support_category_id}/supports/them', 'create')->name('create');
                Route::post('/supports/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewSupport', 'auth:admin']], function () {
                Route::get('/{support_category_id}/supports', 'index')->name('index');
                Route::get('/{support_category_id}/supports/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateSupport', 'auth:admin']], function () {
                Route::put('/supports/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteSupport', 'auth:admin']], function () {
                Route::delete('/supports/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //partner category
    Route::prefix('/partner-categories')->as('partner_category.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\PartnerCategory\PartnerCategoryController::class)->group(function () {
            Route::group(['middleware' => ['permission:createPartnerCategory', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewPartnerCategory', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updatePartnerCategory', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deletePartnerCategory', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //partner
    Route::prefix('/partner')->as('partner.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Partner\PartnerController::class)->group(function () {
            Route::group(['middleware' => ['permission:createPartner', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewPartner', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updatePartner', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deletePartner', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });

        Route::controller(App\Admin\Http\Controllers\PartnerTable\PartnerTableController::class)->group(function () {
            Route::group(['middleware' => ['permission:createPartnerTable', 'auth:admin']], function () {
                Route::get('/{partner_id}/them', 'create')->name('table.create');
                Route::post('/table/them', 'store')->name('table.store');
            });
            Route::group(['middleware' => ['permission:viewPartnerTable', 'auth:admin']], function () {
                Route::get('/{partner_id}/', 'index')->name('table.index');
                Route::get('/table/sua/{id}', 'edit')->name('table.edit');
            });

            Route::group(['middleware' => ['permission:updatePartnerTable', 'auth:admin']], function () {
                Route::put('/table/sua', 'update')->name('table.update');
            });

            Route::group(['middleware' => ['permission:deletePartnerTable', 'auth:admin']], function () {
                Route::delete('/table/xoa/{id}', 'delete')->name('table.delete');
            });
        });
    });

    //Question
    Route::prefix('/question')->as('question.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Question\QuestionController::class)->group(function () {
            Route::group(['middleware' => ['permission:createQuestion', 'auth:admin']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
            });
            Route::group(['middleware' => ['permission:viewQuestion', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            Route::group(['middleware' => ['permission:updateQuestion', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });

            Route::group(['middleware' => ['permission:deleteQuestion', 'auth:admin']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
            });
        });
    });

    //Transaction
    Route::prefix('/transaction')->as('transaction.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Transaction\TransactionController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewTransaction', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');
            });
            Route::group(['middleware' => ['permission:updateTransaction', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
        });
    });

    //Bookings
    Route::prefix('/booking')->as('booking.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Booking\BookingController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewBooking', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');
            });
            Route::group(['middleware' => ['permission:updateBooking', 'auth:admin']], function () {
                Route::put('/sua', 'update')->name('update');
            });
            Route::group(['middleware' => ['permission:viewBooking', 'auth:admin']], function () {
                Route::get('/show/{booking_id}/invoice', 'invoice')->name('invoice');
            });
        });
    });

    //Deal
    Route::prefix('/deal')->as('deal.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Deal\DealController::class)->group(function () {
            Route::group(['middleware' => ['permission:viewDeal', 'auth:admin']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/show/{id}', 'show')->name('show');
            });
        });
    });

    Route::prefix('/quyen')->as('permission.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Permission\PermissionController::class)->group(function () {
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::post('/multiple', 'actionMultipleRecord')->name('multiple');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });

    //module
    Route::prefix('/module')->as('module.')->group(function () {
        Route::controller(App\Admin\Http\Controllers\Module\ModuleController::class)->group(function () {
            Route::get('/them', 'create')->name('create');
            Route::get('/', 'index')->name('index');
            Route::get('/summary', 'summary')->name('summary');
            Route::get('/sua/{id}', 'edit')->name('edit');
            Route::put('/sua', 'update')->name('update');
            Route::post('/them', 'store')->name('store');
            Route::post('/multiple', 'actionMultipleRecord')->name('multiple');
            Route::delete('/xoa/{id}', 'delete')->name('delete');
        });
    });

    //ckfinder
    Route::prefix('/quan-ly-file')->as('ckfinder.')->group(function () {
        Route::any('/ket-noi', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
            ->name('connector');
        Route::any('/duyet', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
            ->name('browser');
    });
    Route::get('/dashboard', [App\Admin\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('dashboard');

    //auth
    Route::controller(App\Admin\Http\Controllers\Auth\ProfileController::class)
        ->prefix('/profile')
        ->as('profile.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });

    Route::controller(App\Admin\Http\Controllers\Auth\ChangePasswordController::class)
        ->prefix('/password')
        ->as('password.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::put('/', 'update')->name('update');
        });
    Route::prefix('/search')->as('search.')->group(function () {
        Route::prefix('/select')->as('select.')->group(function () {
            Route::get('/icon', [App\Admin\Http\Controllers\Icon\IconSearchSelectController::class, 'selectSearch'])->name('icon');
            Route::get('/user', [App\Admin\Http\Controllers\User\UserSearchSelectController::class, 'selectSearch'])->name('user');
            Route::get('/partner', [App\Admin\Http\Controllers\Partner\PartnerSearchSelectController::class, 'selectSearch'])->name('partner');
            Route::get('/subadmin', [App\Admin\Http\Controllers\Admin\AdminSearchSelectController::class, 'selectSearch'])->name('subadmin');
            Route::get('/partner-category', [App\Admin\Http\Controllers\PartnerCategory\PartnerCategorySearchSelectController::class, 'selectSearch'])->name('partner_category');
            Route::get('/partner-table', [App\Admin\Http\Controllers\PartnerTable\PartnerTableSearchSelectController::class, 'selectSearch'])->name('partner_table');
        });
    });

    Route::post('/logout', [App\Admin\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');

    //store
    Route::prefix('/stores')->as('store.')->group(function () {
        Route::group(['middleware' => ['auth:admin', 'permission:viewStore']], function () {
            Route::controller(\App\Admin\Http\Controllers\Store\AreaController::class)
                ->prefix('/areas')
                ->as('areas.')
                ->group(function () {
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/{area}/edit', 'edit')->name('edit');
                    Route::put('/{area}/update', 'update')->name('update');
                    Route::delete('/{area}/delete', 'delete')->name('delete');
                });
        });
        Route::controller(\App\Admin\Http\Controllers\Store\StoreController::class)->group(function () {
            // Xem danh sách
            Route::group(['middleware' => ['auth:admin', 'permission:viewStore']], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/sua/{id}', 'edit')->name('edit');
            });

            // Tạo mới và cập nhật
            Route::group(['middleware' => ['auth:admin', 'permission:createStore|updateStore']], function () {
                Route::get('/them', 'create')->name('create');
                Route::post('/them', 'store')->name('store');
                Route::put('/sua/{id}', 'update')->name('update');

                // Thêm routes mới cho xử lý hình ảnh
                Route::post('/them-hinh-anh', 'storeImage')->name('image.store');
                Route::put('/sua-hinh-anh/{id}', 'updateImage')->name('image.update');
            });

            // Xóa
            Route::group(['middleware' => ['auth:admin', 'permission:deleteStore']], function () {
                Route::delete('/xoa/{id}', 'delete')->name('delete');
                Route::delete('/xoa-hinh-anh/{id}', 'deleteImage')->name('delete.image');
            });
        });
    });
});

Route::prefix('/search')->as('search.')->group(function () {
    Route::prefix('/select')->as('select.')->group(function () {
        Route::get('/province', [App\Admin\Http\Controllers\Province\ProvinceSearchSelectController::class, 'selectSearch'])->name('province');
        Route::get('/district', [App\Admin\Http\Controllers\District\DistrictSearchSelectController::class, 'selectSearch'])->name('district');
        Route::get('/ward', [App\Admin\Http\Controllers\Ward\WardSearchSelectController::class, 'selectSearch'])->name('ward');
    });
});
