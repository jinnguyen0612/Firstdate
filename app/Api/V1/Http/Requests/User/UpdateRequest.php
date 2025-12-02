<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Api\V1\Repositories\Answer\AnswerRepositoryInterface;
use App\Enums\User\Gender;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'avatar' => ['nullable'],
            'fullname' => ['nullable', 'string'],
            'phone' => [
                'nullable',
                'regex:/((09|03|07|08|05)+([0-9]{8})\b)/',
            ],
            'email' => ['nullable', 'email'],
            'lng' => ['nullable'],
            'lat' => ['nullable'],
            'thumbnails' => ['nullable'],
            'min_age_find' => ['nullable'],
            'max_age_find' => ['nullable'],
            'looking_for' => ['nullable'],
            'dating_time' => ['nullable', 'array'],
            'relationship' => ['nullable', 'array'],
            'answer' => ['nullable', 'array', 'min:5'],
            'border_color' => ['nullable'],
            'is_hide' => ['nullable'],
            'is_subsidy_offer' => ['nullable'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $email = $this->email;
            $phone_verified = $this->phone_number;
            $userId = auth()->id();

            if (
                $email && User::where('id', '!=', $userId)
                ->where('email', $email)
                ->exists()
            ) {
                $validator->errors()->add('email', __('Email đã được đăng ký.'));
            }

            if (
                $phone_verified && User::where('phone_number', $phone_verified)
                ->where('id', '!=', $userId)
                ->exists()
            ) {
                $validator->errors()->add('phone_number', __('Số điện thoại đã được đăng ký.'));
            }

            if($this->input('border_color')){
                if(!User::find($userId)->is_premium()){
                    $validator->errors()->add('border_color', __('Vui lòng kích hoặt gói premium để sử dụng chức năng này'));
                }
            }

            if ($this->input('answer')) {
                $answers = $this->input('answer');
                $countRequired = 0;
                $answerRepository = app(AnswerRepositoryInterface::class);
                if (!$answers || count($answers) < 5) {
                    $validator->errors()->add("answer", "Số lượng câu hỏi phải từ 5 trở lên.");
                    return;
                }
                if ($answerRepository->checkDuplicateQuestionByAnswer($answers)) {
                    $validator->errors()->add("answer", "Một câu hỏi không thể trả lời 2 lần.");
                }
                foreach ($answers as $answerId) {
                    if ($answerRepository->checkRequiredQuestionByAnswerId($answerId)) {
                        $countRequired++;
                    }
                }
                if ($countRequired < 2) {
                    $validator->errors()->add("answer", "Số lượng câu trả lời của câu hỏi bắt buộc không đủ.");
                }
            }
        });
    }

    public function messages()
    {
        return [
            'fullname.string' => 'Họ và tên phải là chuỗi ký tự.',
            'birthday.string' => 'Ngày sinh phải là chuỗi ký tự.',
            'email.email' => 'Email không hợp lệ.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
        ];
    }
}
