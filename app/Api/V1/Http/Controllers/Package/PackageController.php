<?php

namespace App\Api\V1\Http\Controllers\Package;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\Package\PackageRequest;
use App\Api\V1\Http\Requests\Package\GetPackageRequest;
use App\Api\V1\Http\Resources\Package\AllPackageResource;
use App\Api\V1\Http\Resources\Package\ShowPackageResource;
use App\Api\V1\Repositories\Package\PackageRepositoryInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group App Setting
 *
 */
class PackageController extends Controller
{
    protected $repository;

    public function __construct(
        PackageRepositoryInterface $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách video hiển thị (App Video Title)
     *
     * ? Danh sách video hiển thị (App Video Title)
     *
     * @responseFile App/Api/V1/Http/Resources/Package/AllPackageResource.json
     */
    public function index(PackageRequest $request)
    {
        try {
            $data = $request->validated();
            $appTitle = $this->repository->paginate(...$data);
            $appTitle = new AllPackageResource($appTitle);

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
