<?php

namespace App\Api\V1\Http\Controllers\District;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\District\DistrictRequest;
use App\Api\V1\Http\Resources\District\AllDistrictResource;
use App\Api\V1\Repositories\District\DistrictRepositoryInterface;
use App\Api\V1\Services\District\DistrictServiceInterface;
use App\Api\V1\Services\District\DistrictService;
use App\Models\District;

/**
 * @group Khu vực
 */

class DistrictController extends Controller
{
    public function __construct(
        DistrictRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }
    /**
     * DS Quận
     *
     * Lấy danh sách các Quận.
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
     * @queryParam province_id integer required
     * id province. Example: 20
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
     */
    public function index(DistrictRequest $request)
    {
        try {
            $data = $request->validated();
            $districts = $this->repository->getDistrictByProvince(...$data);
            $districts = new AllDistrictResource($districts);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $districts
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
