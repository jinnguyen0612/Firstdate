<?php

namespace App\Api\V1\Http\Controllers\Deal;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Deal\ChooseDateOptionsRequest;
use App\Api\V1\Http\Requests\Deal\ChooseDistrictOptionsRequest;
use App\Api\V1\Http\Requests\Deal\ChoosePartnerOptionsRequest;
use App\Api\V1\Http\Requests\Deal\DealCancelRequest;
use App\Api\V1\Http\Requests\Deal\DealRequest;
use App\Api\V1\Http\Resources\Deal\DealResource;
use App\Api\V1\Repositories\Deal\DealRepositoryInterface;
use App\Api\V1\Services\Deal\DealServiceInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group Lên kèo
 *
 */
class DealController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(
        DealRepositoryInterface $repository,
        DealServiceInterface $service,
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Danh sách lên kèo của user
     *
     * Lấy danh sách lên kèo của user
     *
     * @authenticated
     * @header X-TOKEN-ACCESS string Token để truy cập API
     *
     * @queryParam page int Số trang hiện tại (>0). Example: 1
     * @queryParam limit int Số bản ghi mỗi trang (>0). Example: 10
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/AllDealResource.json
     */
    public function index(DealRequest $request)
    {
        try {
            $data = $request->validated();
            $deal = $this->repository->getDealByCurrentUser(...$data);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => DealResource::collection($deal)
            ]);
        } catch (\Exception $e) {
            Log::error('Error listing Question: ' . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ],400);
        }
    }

    /**
     * Lấy thông tin cuộc hẹn
     *
     * ? Lấy thông tin cuộc hẹn
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @urlParam id required.
     * Mã kèo. Example: 3
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/DealResource.json
     */
    public function show($id)
    {

        $deal = $this->repository->findDeal($id);
        if(!$deal) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy kèo.')
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => new DealResource($deal)
        ]);
    }

    /**
     * Chọn các quận khi lên kèo (NỮ/NGƯỜI MATCH SAU)
     *
     * Nữ chọn 5 quận cho Nam chọn.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam deal_id required.
     * Mã kèo đã lên. Example: 3
     *
     * @bodyParam districts required.
     * Danh sách quận. Example: [545,552,536,544,547]
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/BaseChooseOptionsResource.json
     */
    public function chooseDistrictOptions(ChooseDistrictOptionsRequest $request)
    {
        $response = $this->service->chooseDistrictOptions($request);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Thêm danh sách thành công.')
            ]);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Thêm danh sách thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Đã tồn tại danh sách.')
            ], 409);
        }
    }

    /**
     * Chọn quận từ các options (NAM/NGƯỜI MATCH TRƯỚC)
     *
     * Chọn quận từ các options
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @urlParam id required. Mã của options. Example: 3
     *
     * @responseFile App/Api/V1/Http/Resources/Deal/BaseChooseFromOptionsResource.json
     *
     */
    public function chooseDistrictFromOptions($id)
    {
        $response = $this->service->chooseDistrictFromOptions($id);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Chọn quận từ các options thành công.')
            ]);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Đã có option được chọn.')
            ], 409);
        }
        if ($response == 404) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy kèo đã chọn.')
            ], 404);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Chọn quận từ các options thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
    }

    /**
     * Chọn các thời gian khi lên kèo (NỮ/NGƯỜI MATCH SAU)
     *
     * Nữ chọn 5 thời gian cho Nam chọn 1.
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam deal_id required
     * Mã kèo đã lên. Example: 3
     *
     * @bodyParam dates required
     * Danh sách ngày. Example: [ {     "date": "2022-01-01",     "from": "00:00:00",     "to": "23:59:59" }, {     "date": "2022-01-02",     "from": "00:00:00",     "to": "23:59:59" }, {     "date": "2022-01-03",     "from": "00:00:00",     "to": "23:59:59" }, {     "date": "2022-01-04",     "from": "00:00:00",     "to": "23:59:59" }, {     "date": "2022-01-05",     "from": "00:00:00",     "to": "23:59:59" }]
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/BaseChooseOptionsResource.json
     *
     */
    public function chooseDateOptions(ChooseDateOptionsRequest $request)
    {
        $response = $this->service->chooseDateOptions($request);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Thêm danh sách thành công.')
            ]);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Thêm danh sách thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Đã tồn tại danh sách.')
            ], 409);
        }
    }

    /**
     * Chọn Ngày từ các options (NAM/NGƯỜI MATCH TRƯỚC)
     *
     * Chọn Ngày từ các options
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @urlParam id int required. Mã của option. Example: 3
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/BaseChooseFromOptionsResource.json
     *
     */
    public function chooseDateFromOptions($id)
    {
        $response = $this->service->chooseDateFromOptions($id);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Chọn ngày từ các options thành công.')
            ]);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Đã có option được chọn.')
            ],409);
        }
        if ($response == 404) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy kèo đã chọn.')
            ], 404);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Chọn ngày từ các options thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
    }


    /**
     * Chọn các địa điểm (đối tác) khi lên kèo (NỮ/NGƯỜI MATCH SAU)
     *
     * Nữ chọn 5 địa điểm (đối tác) cho Nam chọn.
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam deal_id required
     * Mã kèo đã lên. Example: 3
     *
     * @bodyParam partners required
     * Danh sách đối tác. Example: [1,2,3,4,5]
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/BaseChooseOptionsResource.json
     *
     */
    public function choosePartnerOptions(ChoosePartnerOptionsRequest $request)
    {
        $response = $this->service->choosePartnerOptions($request);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Thêm danh sách thành công.')
            ]);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Thêm danh sách thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Đã tồn tại danh sách.')
            ], 409);
        }
    }

    /**
     * Chọn địa điểm (đối tác) từ các options (NAM/NGƯỜI MATCH TRƯỚC)
     *
     * Chọn địa điểm (đối tác) từ các options
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @urlParam id int required. Mã của người dùng nhận thông báo
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/BaseChooseFromOptionsResource.json
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function choosePartnerFromOptions($id)
    {
        $response = $this->service->choosePartnerFromOptions($id);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Chọn địa điểm từ các options thành công.')
            ]);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Đã có option được chọn.')
            ], 409);
        }
        if ($response == 404) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy kèo đã chọn.')
            ], 404);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Chọn địa điểm từ các options thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
    }

    /**
     * Hủy lên kèo
     *
     * Hủy lên kèo đồng thời hủy matching
     *
     * @header X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @bodyParam id int required
     * Mã của kèo. Example: 3
     *
     * @bodyParam reason string required
     * Lý do hủy. Example: Bệnh
     *
     * @responseFile app/Api/V1/Http/Resources/Deal/CancelDealResource.json
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel(DealCancelRequest $request)
    {
        $response = $this->service->cancel($request);
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Hủy kèo thành công.')
            ]);
        }
        if ($response == 400){
            return response()->json([
                'status' => 400,
                'message' => __('Hủy kèo thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
        if ($response == 404){
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy kèo.')
            ], 404);
        }
    }
}
