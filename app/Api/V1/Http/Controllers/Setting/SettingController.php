<?php

namespace App\Api\V1\Http\Controllers\Setting;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Repositories\Setting\SettingRepositoryInterface;
use App\Api\V1\Http\Resources\Setting\SettingResource;
use App\Enums\Setting\SettingGroup;

/**
 * @group Cài đặt
 */

class SettingController extends Controller
{

    public function __construct(
        SettingRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    /**
     * Thông tin cài đặt
     *
     * ? Thông tin cài đặt
     *
     * @responseFile 200 App/Api/V1/Http/Resources/Setting/SettingResource.json
     */
    public function index()
    {
        $settings = $this->repository->getBy(['group' => SettingGroup::General()]);
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => SettingResource::collection($settings)
        ]);
    }

    /**
     * Thông tin điều khoản và chính sách
     *
     * ? Thông tin điều khoản và chính sách
     *
     * @responseFile 200 App/Api/V1/Http/Resources/Setting/SettingResource.json
     */
    public function policy()
    {
        $settings = $this->repository->getQueryBuilder()->where('setting_key', 'policy')->first();
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => new SettingResource($settings)
        ]);
    }

    /**
     * Thông tin về chúng tôi
     *
     * ? Thông tin về chúng tôi
     *
     * @responseFile 200 App/Api/V1/Http/Resources/Setting/SettingResource.json
     */
    public function aboutUs()
    {
        $settings = $this->repository->getQueryBuilder()->where('setting_key', 'information')->first();
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => new SettingResource($settings)
        ]);
    }

    /**
     * Thông tin liên hệ
     *
     * ? Thông tin liên hệ
     * @responseFile 200 App/Api/V1/Http/Resources/Setting/SettingResource.json
     */

    public function contact()
    {
        $settings = $this->repository->getQueryBuilder()->where('setting_key', 'zalo')
            ->orWhere('setting_key', 'phone')
            ->orWhere('setting_key', 'gmail')
            ->orWhere('setting_key', 'instagram')
            ->orWhere('setting_key', 'facebook')
            ->get();
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => SettingResource::collection($settings)
        ]);
    }
}
