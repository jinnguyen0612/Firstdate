<?php

namespace App\Api\V1\Http\Controllers\Question;

use App\Admin\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\V1\Http\Requests\Question\QuestionRequest;
use App\Api\V1\Http\Resources\Question\{AllQuestionResource, ShowQuestionResource};
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Api\V1\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Support\Facades\Log;

/**
 * @group Câu hỏi gợi ý
 */
class QuestionController extends Controller
{
    protected $repository;

    public function __construct(
        QuestionRepositoryInterface $repository,
        protected AnswerRepositoryInterface $answerRepository,
    ) {
        $this->repository = $repository;
    }

    /**
     * Danh sách Câu hỏi gợi ý
     *
     * Lấy danh sách Câu hỏi gợi ý
     *
     * @authenticated
     * @header X-TOKEN-ACCESS string Token để truy cập API
     *
     * @queryParam required int 
     * Tìm kiếm theo câu hỏi bắt buộc hay không. Example: 1
     * 
     * <ul>
     *   <li>1: Câu hỏi bắt buộc trả lời</li>
     *   <li>0: Câu hỏi không bắt buộc trả lời</li>
     * </ul>
     * 
     * @queryParam page int Số trang hiện tại (>0). Example: 1
     * @queryParam limit int Số bản ghi mỗi trang (>0). Example: 10
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": [
     *          {
     *              "id": 1,
     *              "question_content": "Thông tin về Question content"
     *          }
     *      ]
     * }
     * @response 400 {
     *      "status": 400,
     *      "message": "Vui lòng kiểm tra lại các trường dữ liệu"
     * }
     * @response 500 {
     *      "status": 500,
     *      "message": "Thực hiện thất bại."
     * }
     */
    public function index(QuestionRequest $request)
    {
        try {
            $data = $request->validated();
            $questions = $this->repository->paginate(...$data);
            $questions = new AllQuestionResource($questions);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $questions
            ]);
        } catch (\Exception $e) {
            Log::error('Error listing Question: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => __('Thực hiện thất bại.')
            ]);
        }
    }

    /**
     * Chi tiết Câu hỏi gợi ý
     *
     * Lấy thông tin chi tiết của Câu hỏi gợi ý
     *
     * @authenticated
     * @header X-TOKEN-ACCESS string Token để truy cập API
     *
     * @urlParam id int required ID của Câu hỏi gợi ý. Example: 1
     *
     * @response 200 {
     *      "status": 200,
     *      "message": "Thực hiện thành công.",
     *      "data": {
     *              "id": 1,
     *              "question_content": "Thông tin về Question content"
     *      }
     * }
     * @response 404 {
     *      "status": 404,
     *      "message": "Không tìm thấy dữ liệu."
     * }
     * @response 500 {
     *      "status": 500,
     *      "message": "Thực hiện thất bại."
     * }
     */
    public function show($id)
    {
        try {
            $question = $this->repository->find($id);
            $answer = $this->answerRepository->getQueryBuilder()->where('question_id',$id)->get();
            $question = new ShowQuestionResource(['question'=>$question,'answer'=>$answer]);

            return response()->json([
                'status' => 200,
                'message' => __('Thực hiện thành công.'),
                'data' => $question
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching Question details: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'message' => __('Thực hiện thất bại.'),
                'error' => $e->getMessage()
            ]);
        }
    }
}
