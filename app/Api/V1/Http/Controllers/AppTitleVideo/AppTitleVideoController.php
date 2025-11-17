<?php

namespace App\Api\V1\Http\Controllers\AppTitleVideo;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\AppTitleVideo\AppTitleVideoRequest;
use App\Api\V1\Http\Requests\AppTitleVideo\GetAppTitleVideoRequest;
use App\Api\V1\Http\Resources\AppTitleVideo\AllAppTitleVideoResource;
use App\Api\V1\Http\Resources\AppTitleVideo\ShowAppTitleVideoResource;
use App\Api\V1\Repositories\AppTitleVideo\AppTitleVideoRepositoryInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group App Setting
 *
 */
class AppTitleVideoController extends Controller
{
    protected $repository;

    public function __construct(
        AppTitleVideoRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách video hiển thị (App Video Title) 
     *
     * ? Danh sách video hiển thị (App Video Title)
     *
     * @responseFile App/Api/V1/Http/Resources/AppTitleVideo/AllAppTitleVideoResource.json
     */
    public function index(AppTitleVideoRequest $request)
    {
        try {
            $data = $request->validated();
            $appTitle = $this->repository->paginate(...$data);
            $appTitle = new AllAppTitleVideoResource($appTitle);

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

    /**
     * Lấy tiêu đề theo key (App Video Title)
     *
     * ? Lấy tiêu đề theo key (App Video Title)
     * 
     * @queryParam key string required.
     * Từ khóa tiêu đề. Example: home
     *
     * @responseFile App/Api/V1/Http/Resources/AppTitleVideo/ShowAppTitleVideoResource.json
     */

    public function getAppTitle(GetAppTitleVideoRequest $request)
    {
        try {
            $data = $request->validated();
            if (isset($data['key'])) {
                $appTitle = $this->repository->findByField('key', $data['key']);
                $appTitle = new ShowAppTitleVideoResource($appTitle);
            } else {
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
