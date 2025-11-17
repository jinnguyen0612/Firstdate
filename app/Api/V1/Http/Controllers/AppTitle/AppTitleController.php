<?php

namespace App\Api\V1\Http\Controllers\AppTitle;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\AppTitle\AppTitleRequest;
use App\Api\V1\Http\Requests\AppTitle\GetAppTitleRequest;
use App\Api\V1\Http\Resources\AppTitle\AllAppTitleResource;
use App\Api\V1\Http\Resources\AppTitle\ShowAppTitleResource;
use App\Api\V1\Repositories\AppTitle\AppTitleRepositoryInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group App Setting
 *
 */
class AppTitleController extends Controller
{
    protected $repository;

    public function __construct(
        AppTitleRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách tiêu đề hiển thị (APP Title)
     *
     * ? Danh sách tiêu đề hiển thị (APP Title)
     *
     * @responseFile App/Api/V1/Http/Resources/AppTitle/AllAppTitleResource.json
     */

    public function index(AppTitleRequest $request)
    {
        try {
            $data = $request->validated();
            $appTitle = $this->repository->paginate(...$data);
            $appTitle = new AllAppTitleResource($appTitle);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $appTitle
            ]);
        } catch (\Exception $e) {
            Log::error('Error listing App Category: ' . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện không thành công.')
            ], 400);
        }
    }

    /**
     * Lấy tiêu đề theo key (APP Title)
     *
     * ? Lấy tiêu đề theo key (APP Title)
     * 
     * @queryParam key string required.
     * Từ khóa tiêu đề. Example: home
     *
     * @responseFile App/Api/V1/Http/Resources/AppTitle/ShowAppTitleResource.json
     */

    public function getAppTitle(GetAppTitleRequest $request)
    {
        try {
            $data = $request->validated();
            if(isset($data['key'])){
                $appTitle = $this->repository->findByField('key',$data['key']);
                $appTitle = new ShowAppTitleResource($appTitle);
            }else{
                $appTitle = [];
            }

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $appTitle
            ]);
        } catch (\Exception $e) {
            Log::error('Error listing App Category: ' . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ], 400);
        }
    }
}