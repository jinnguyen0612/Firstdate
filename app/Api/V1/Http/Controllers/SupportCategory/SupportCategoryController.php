<?php

namespace App\Api\V1\Http\Controllers\SupportCategory;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\SupportCategory\SupportCategoryRequest;
use App\Api\V1\Http\Resources\SupportCategory\SupportCategoryResource;
use App\Api\V1\Repositories\SupportCategory\SupportCategoryRepositoryInterface;

/**
 * @group Câu hỏi hỗ trợ
 */

class SupportCategoryController extends Controller
{

    public function __construct(
        SupportCategoryRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    /**
     * Danh mục Câu hỏi hỗ trợ
     *
     * ? Danh mục Câu hỏi hỗ trợ
     *
     */
    public function index(SupportCategoryRequest $request)
    {
        $supportCategory = $this->repository->getAllPaginate(...$request->validated());
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => SupportCategoryResource::collection($supportCategory)
        ]);
    }

}
