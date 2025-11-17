<?php

namespace App\Api\V1\Http\Controllers\Province;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\Province\ProvinceRequest;
use App\Api\V1\Http\Resources\Province\AllProvinceResource;
use App\Api\V1\Repositories\Province\ProvinceRepositoryInterface;
use App\Api\V1\Services\Province\ProvinceServiceInterface;
use App\Api\V1\Services\Province\ProvinceService;

/**
 * @group Khu vực
 */

class ProvinceController extends Controller
{
    public function __construct(
        ProvinceRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }
    /**
     * DS Thành phố
     *
     * Lấy danh sách các Thành phố.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam page integer
     * Trang hiện tại, page > 0. Ví dụ: 1
     *
     * @queryParam limit integer
     * Số lượng Phòng trong 1 trang, limit > 0. Ví dụ: 1
     *
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *         {
     *               "id": 4,
     *               "name": "Tên Tỉnh Thành phố"
     *         }
     *      ]
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Vui lòng kiểm tra lại các trường field"
     * }
     * @response 500 {
     *      "status": 500,
     *      "message": "Thực hiện thất bại."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $provinces = $this->repository->getAllOrderBy();
            $provinces = new AllProvinceResource($provinces);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $provinces
            ]);
        } catch (\Exception $e) {
            // Xử lý ngoại lệ nếu cần thiết
            return response()->json([
                'status' => 500,
                'message' => __('Thực hiện thất bại.')
            ]);
        }
    }
}
