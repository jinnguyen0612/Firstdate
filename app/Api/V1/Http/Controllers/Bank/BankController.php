<?php

namespace App\Api\V1\Http\Controllers\Bank;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Bank\BankRequest;
use App\Api\V1\Http\Resources\Bank\BankResource;
use App\Api\V1\Repositories\Bank\BankRepositoryInterface;

/**
 * @group Thông tin
 */

class BankController extends Controller
{

    public function __construct(
        BankRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }
    /**
     * Danh mục Câu hỏi hỗ trợ
     *
     * ? Danh mục Câu hỏi hỗ trợ
     *
     */
    public function index(BankRequest $request)
    {
        $bank = $this->repository->getAllPaginate(...$request->validated());
        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => BankResource::collection($bank)
        ]);
    }

}
