<?php

namespace App\Api\V1\Http\Controllers\Booking;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Booking\ChooseDateOptionsRequest;
use App\Api\V1\Http\Requests\Booking\ChooseDistrictOptionsRequest;
use App\Api\V1\Http\Requests\Booking\ChoosePartnerOptionsRequest;
use App\Api\V1\Http\Requests\Booking\BookingRequest;
use App\Api\V1\Http\Resources\Booking\BookingResource;
use App\Api\V1\Repositories\Booking\BookingRepositoryInterface;
use App\Api\V1\Services\Booking\BookingServiceInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group Lên kèo
 *
 */
class BookingController extends Controller
{
    protected $repository;
    protected $service;

    public function __construct(
        BookingRepositoryInterface $repository,
        BookingServiceInterface $service,
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Trả tiền cọc cho cuộc hẹn
     *
     * Trả tiền cọc cho cuộc hẹn
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Ví dụ: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @pathParam id String(200) required
     * Mã kèo của người dùng
     *
     * @responseFile App/Api/V1/Http/Resources/Booking/PayDeposit.json
     * 
     */
    public function payDeposit($id)
    {
        $response = $this->service->payDeposit($id);
        if ($response == 404) {
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy yêu cầu cọc tiền.')
            ], 404);
        }
        if ($response == 409) {
            return response()->json([
                'status' => 409,
                'message' => __('Người dùng này đã cọc tiền.')
            ], 409);
        }
        if ($response == 200) {
            return response()->json([
                'status' => 200,
                'message' => __('Cọc tiền thành công.')
            ], 200);
        }
        if ($response == 400) {
            return response()->json([
                'status' => 400,
                'message' => __('Cọc tiền thất bại. Hãy kiểm tra lại.')
            ], 400);
        }
    }
}
