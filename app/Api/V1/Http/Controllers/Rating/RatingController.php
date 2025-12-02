<?php

namespace App\Api\V1\Http\Controllers\Rating;

use App\Admin\Http\Controllers\Controller;
use App\Admin\Traits\AuthService;
use App\Api\V1\Http\Requests\Rating\RatingRequest;
use App\Api\V1\Http\Requests\Rating\GetRatingRequest;
use App\Api\V1\Http\Requests\Rating\UpdateRatingRequest;
use App\Api\V1\Http\Resources\Rating\AllRatingResource;
use App\Api\V1\Http\Resources\Rating\ShowRatingResource;
use App\Api\V1\Repositories\Rating\RatingRepositoryInterface;
use App\Api\V1\Services\Rating\RatingServiceInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group App Setting
 *
 */
class RatingController extends Controller
{
    use AuthService;

    protected $service;
    protected $repository;

    public function __construct(
        RatingRepositoryInterface $repository,
        RatingServiceInterface $service,
    ) {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Danh sách video hiển thị (App Video Title)
     *
     * ? Danh sách video hiển thị (App Video Title)
     *
     * @responseFile App/Api/V1/Http/Resources/Rating/AllRatingResource.json
     */
    public function index(RatingRequest $request)
    {
        try {
            $data = $request->validated();
            $rating = $this->repository->paginate(...$data);
            $rating = AllRatingResource::collection($rating);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $rating
            ]);
        } catch (\Exception $e) {
            Log::error('Error listing rating: ' . $e->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            //code...
            $rating = $this->repository->findOrFail($id);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => new ShowRatingResource($rating)
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error listing Question: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ], 400);
        }
    }

    public function create(RatingRequest $request)
    {
        try {
            $response = $this->service->create($request);
            if(!$response){
                return response()->json([
                    'status' => 409,
                    'message' => __('Đã tồn tại đánh giá.')
                ], 409);
            }
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => new ShowRatingResource($response),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error listing Question: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ], 400);
        }
    }

    public function update(UpdateRatingRequest $request)
    {
        try {
            //code...
            $id = $request->id;
            $rating = $this->repository->findOrFail($id);
            $currentUser = $this->getCurrentUser();
            if($rating->user_id != $currentUser->id){
                return response()->json([
                    'status' => 403,
                    'message' => __('Không có quyền chỉnh sửa đánh giá này.')
                ], 403);
            }

            $response = $this->service->update($request);
            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => new ShowRatingResource($response),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Error listing rating: ' . $th->getMessage());
            return response()->json([
                'status' => 400,
                'message' => __('Thực hiện thất bại.')
            ], 400);
        }
    }
}
