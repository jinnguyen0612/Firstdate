<?php

namespace App\Api\V1\Http\Controllers\Matching;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Traits\AuthService;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\Matching\MatchingRequest;
use App\Api\V1\Http\Requests\Matching\MatchingSuccessRequest;
use App\Api\V1\Http\Requests\Matching\UnmatchingRequest;
use App\Api\V1\Http\Resources\User\ShowAllUserMatchingResource;
use App\Api\V1\Http\Resources\User\ShowAllUserResource;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Api\V1\Repositories\Matching\MatchingRepositoryInterface;
use App\Api\V1\Repositories\User\UserRepositoryInterface;
use App\Api\V1\Services\Matching\MatchingServiceInterface;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Commands\Show;

/**
 * @group Ghép đôi
 */
class MatchingController extends Controller
{
    use AuthService;

    protected $repository;
    protected $service;

    public function __construct(
        MatchingRepositoryInterface $repository,
        MatchingServiceInterface $service,
        protected UserRepositoryInterface $userRepository,
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Danh sách hồ sơ đã thích mình
     *
     * Lấy danh sách hồ sơ đã thích mình.
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam limit int Số lượng bản ghi trên mỗi trang. Example: 10
     * @queryParam page int Trang hiện tại. Example: 1
     *
     * @responseFile App/Api/V1/Http/Resources/Matching/ShowAllUserUnmatchingResource.json
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */

    public function index(UnmatchingRequest $request)
    {
        $data = $request->validated();
        $user = $this->getCurrentUser();
        try {
            // Gọi Repository để lấy danh sách những người thích mình nhưng mình chưa thích lại
            $unmatchedLovers = $this->repository->getUnmatchedLovers($user->id, ...$data);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công'),
                'data' => ShowAllUserMatchingResource::collection($unmatchedLovers),
            ]);
        } catch (\Throwable $th) {
            Log::error('Error listing Question: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại. Hãy kiểm tra lại'),
            ], 400);
        }
    }

    /**
     * Chọn thích hồ sơ
     *
     * Chọn một người để thích lại người đó.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam user_loved_id string required
     * Id của người mình muốn thích. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thích thành công."
     * }
     * @response 400 {
     *      "status": 200,
     *      "message": "Thích thất bại. Hãy kiểm tra lại."
     * }
     */
    public function add(MatchingRequest $request)
    {

        $response = $this->service->add($request);
        if ($response['success'] == true) {
            return response()->json([
                'status' => 200,
                'message' => $response['message'],
                'data' => [
                    'is_matching' => $response['is_matching'],
                ],
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => $response['message']
        ], 400);
    }

    /**
     * Chọn từ chối hồ sơ
     *
     * Xóa hồ sơ thích mình ra khỏi bảng danh sách hồ sơ đã thích mình.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @pathParam user_id string required
     * Id của người mình muốn từ chối. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Từ chối thành công."
     * }
     *
     * @response 400 {
     *      "status": 400,
     *      "message": "Từ chối không thành công."
     * }
     */
    public function delete(MatchingRequest $request)
    {

        $user = $this->getCurrentUser();

        $updatedRequest = new Request([
            'user_id' => $request->user_id, // ID của người thích mình
            'user_loved_id' => $user->id
        ]);
        $response = $this->service->delete($updatedRequest);

        if ($response) {
            return response()->json([
                'status' => 200,
                'message' => __('Từ chối thành công.')
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => __('Từ chối thất bại.')
        ], 400);
    }

    /**
     * Danh sách hồ sơ đã ghép đôi
     *
     * Lấy danh sách hồ sơ đã ghép đôi là những người thích mình và mình thích họ.
     *
     * @authenticated Authorization string required
     * access_token được cấp sau khi đăng nhập. Example: Bearer 1|WhUre3Td7hThZ8sNhivpt7YYSxJBWk17rdndVO8K
     *
     * @headersParam X-TOKEN-ACCESS string required
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam keyword string Từ khóa tìm kiếm theo tên (không bắt buộc). Example: Bảo
     * @queryParam limit int Số lượng bản ghi trên mỗi trang. Example: 10
     * @queryParam page int Trang hiện tại. Example: 1
     *
     * @responseFile app/Api/V1/Http/Resources/Matching/ShowAllUserMatchingResource.json
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function matchingSuccess(MatchingSuccessRequest $request)
    {
        $data = $request->validated();
        $user = $this->getCurrentUser();
        try {
            //code...
            $mutualLoves = $this->repository->getMatchingSuccess($user->id, ...$data);

            return response()->json([
                'status' => 200,
                'message' => __('notifySuccess'),
                'data' => ShowAllUserMatchingResource::collection($mutualLoves)
            ]);
        } catch (\Throwable $th) {
            Log::error('Error listing Question: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('notifyFail'),
            ], 400);
        }
    }
}
