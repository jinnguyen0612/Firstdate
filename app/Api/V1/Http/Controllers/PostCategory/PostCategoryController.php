<?php

namespace App\Api\V1\Http\Controllers\PostCategory;

use App\Admin\Http\Controllers\Controller;
use App\Api\V1\Http\Requests\PostCategory\PostCategoryRequest;
use App\Api\V1\Http\Resources\PostCategory\AllPostCategoryTreeResource;
use App\Api\V1\Http\Resources\PostCategory\ShowCategoryWithPostResource;
use App\Api\V1\Repositories\PostCategory\PostCategoryRepositoryInterface;
use App\Api\V1\Repositories\Post\PostRepositoryInterface;
use \Illuminate\Http\Request;

/**
 * @group Chuyên mục
 */

class PostCategoryController extends Controller
{
    protected $repositoryProduct;
    protected $repositoryPost;
    public function __construct(
        PostCategoryRepositoryInterface $repository,
        PostRepositoryInterface $repositoryPost
    ) {
        $this->repository = $repository;
        $this->repositoryPost = $repositoryPost;
    }

    /**
     * Danh sách danh mục bài viết
     *
     * Lấy danh sách danh mục bài viết.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @queryParam limit integer
     * Số lượng bài viết muốn lấy mỗi chuyên mục. Example: 4
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *               "id": 7,
     *               "name": "parent 3",
     *               "slug": "parent-3",
     *               "children": [
     *                   {
     *                       "id": 8,
     *                       "name": "child 3",
     *                       "slug": "child-3"
     *                   }
     *               ]
     *           }
     *      ]
     * }
     */
    public function index(Request $request)
    {

        $categories = $this->repository->getTree();
        $categories = new AllPostCategoryTreeResource($categories);

        return response()->json([
            'status' => 200,
            'message' => __('Thực hiện thành công.'),
            'data' => $categories
        ]);
    }
    /**
     * Chi tiết chuyên mục
     *
     * Lấy chi tiết chuyên mục.
     *
     * @headersParam X-TOKEN-ACCESS string
     * token để lấy dữ liệu. Example: ijCCtggxLEkG3Yg8hNKZJvMM4EA1Rw4VjVvyIOb7
     *
     * @pathParam id integer required
     * id hoặc chuyên mục. Example: 1
     *
     * @queryParam limit integer
     * Số lượng bài viết muốn lấy mỗi chuyên mục. Example: 4
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thao tác thành công.",
     *      "data": {
     *          "id": 1,
     *          "name": "Tin tức",
     *          "slug": "tin-tuc",
     *          "parents": [],
     *          "posts": [
     *               {
     *                   "id": 17,
     *                   "title": "Giới thiệu BahaGroup 4",
     *                   "slug": "gioi-thieu-bahagroup-4",
     *                   "image": "https://demo.appmart.vn/userfiles/files/123.jpg",
     *                   "is_featured": true,
     *                   "excerpt": "⭐ BahaGroup là một tập đoàn đa ngành, cung cấp nhiều sản phẩm và dịch vụ khác nhau.",
     *                   "posted_at": "2024-09-30 09:32:08"
     *               },
     *               {
     *                   "id": 14,
     *                   "title": "Giới thiệu BahaGroup 3",
     *                   "slug": "gioi-thieu-bahagroup-3",
     *                   "image": "https://demo.appmart.vn/userfiles/files/123.jpg",
     *                   "is_featured": true,
     *                   "excerpt": "⭐ BahaGroup là một tập đoàn đa ngành, cung cấp nhiều sản phẩm và dịch vụ khác nhau.",
     *                   "posted_at": "2024-09-30 09:32:08"
     *               },
     *               {
     *                   "id": 11,
     *                   "title": "Giới thiệu BahaGroup 2",
     *                   "slug": "gioi-thieu-bahagroup-2",
     *                   "image": "https://demo.appmart.vn/userfiles/files/123.jpg",
     *                   "is_featured": true,
     *                   "excerpt": "⭐ BahaGroup là một tập đoàn đa ngành, cung cấp nhiều sản phẩm và dịch vụ khác nhau.",
     *                   "posted_at": "2024-09-30 09:32:08"
     *               },
     *               {
     *                   "id": 1,
     *                   "title": "Giới thiệu BahaGroup",
     *                   "slug": "gioi-thieu-bahagroup",
     *                   "image": "https://demo.appmart.vn/userfiles/files/123.jpg",
     *                   "is_featured": true,
     *                   "excerpt": "⭐ BahaGroup là một tập đoàn đa ngành, cung cấp nhiều sản phẩm và dịch vụ khác nhau.",
     *                   "posted_at": "2024-09-30 09:32:08"
     *               }
     *           ]
     *       }
     * }
     */
    public function show($id, PostCategoryRequest $request)
    {
        try {
            $category = $this->repository->findByIdWithAncestorsAndDescendants($id);
            $category = new ShowCategoryWithPostResource($category, $this->repositoryPost);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $category
            ]);
        } catch (\Throwable $th) {
            throw $th;
            return response()->json([
                'status' => 404,
                'message' => __('Không tìm thấy dữ liệu')
            ], 404);
        }
    }
}
