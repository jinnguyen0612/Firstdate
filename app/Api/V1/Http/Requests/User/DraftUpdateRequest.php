<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Validation\Validator;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;



class DraftUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'user_id' => ['nullable'],
            'fullname' => ['required', 'string'],
            'birthday' => ['required', 'date'],
            'gender' => ['required', 'string'],
            // 'district_id' => ['nullable'],
            'lng' => ['nullable'],
            'lat' => ['nullable'],
            'min_age_find' => ['required'],
            'max_age_find' => ['required'],
            'looking_for' => ['required'],
            'avatar' => ['required'],
            'thumbnails' => ['nullable'],
            'is_hide' => ['nullable'],
            'answer' => ['required', 'array', 'min:5'],
            'dating_time' => ['required', 'array'],
            'relationship' => ['required', 'array'],
            'is_subsidy_offer' => ['required', 'boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $answers = $this->input('answer');
            $countRequired = 0;
            $answerRepository = app(AnswerRepositoryInterface::class);
            if(!$answers || count($answers) < 5){
                $validator->errors()->add("answer", "Số lượng câu hỏi phải từ 5 trở lên.");
                return;
            }
            if($answerRepository->checkDuplicateQuestionByAnswer($answers)){
                $validator->errors()->add("answer", "Một câu hỏi không thể trả lời 2 lần.");
            }
            foreach ($answers as $answerId) {
                if($answerRepository->checkRequiredQuestionByAnswerId($answerId)){
                    $countRequired++;
                }
            }
            if($countRequired < 2){
                $validator->errors()->add("answer", "Số lượng câu trả lời của câu hỏi bắt buộc không đủ.");
            }

        });
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Họ và tên không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',
        ];
    }
}
