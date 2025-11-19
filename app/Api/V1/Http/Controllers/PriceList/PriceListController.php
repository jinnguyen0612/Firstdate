<?php

namespace App\Api\V1\Http\Controllers\PriceList;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\PriceList\PriceListRequest;
use App\Api\V1\Http\Requests\PriceList\GetPriceListRequest;
use App\Api\V1\Http\Resources\PriceList\AllPriceListResource;
use App\Api\V1\Http\Resources\PriceList\ShowPriceListResource;
use App\Api\V1\Repositories\PriceList\PriceListRepositoryInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group App Setting
 *
 */
class PriceListController extends Controller
{
    protected $repository;

    public function __construct(
        PriceListRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách video hiển thị (App Video Title)
     *
     * ? Danh sách video hiển thị (App Video Title)
     *
     * @responseFile App/Api/V1/Http/Resources/PriceList/AllPriceListResource.json
     */
    public function index(PriceListRequest $request)
    {
        try {
            $data = $request->validated();
            $appTitle = $this->repository->paginate(...$data);
            $appTitle = new AllPriceListResource($appTitle);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $appTitle
            ]);
        } catch (\Exception $e) {
            Log::error('Error listing price list: ' . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ], 400);
        }
    }
}
