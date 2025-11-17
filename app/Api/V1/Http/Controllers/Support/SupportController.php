<?php

namespace App\Api\V1\Http\Controllers\Support;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Support\SupportRequest;
use App\Api\V1\Http\Resources\Support\DetailSupportResource;
use App\Api\V1\Http\Resources\Support\SupportResource;
use App\Api\V1\Repositories\Support\SupportRepositoryInterface;

/**
 * @group Câu hỏi hỗ trợ
 */

class SupportController extends Controller
{

    public function __construct(
        SupportRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    /**
     * Danh mục Câu hỏi hỗ trợ
     *
     * ? Danh mục Câu hỏi hỗ trợ
     *
     */
    public function index(SupportRequest $request)
    {
        $support = $this->repository->getAllPaginate(...$request->validated());
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => SupportResource::collection($support)
        ]);
    }


    public function show($id)
    {
        $support = $this->repository->findOrFail($id);
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => new DetailSupportResource($support)
        ]);
    }

}
