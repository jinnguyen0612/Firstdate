<?php

namespace App\Admin\Http\Requests\Question;

use App\Admin\Http\Requests\BaseRequest;

class QuestionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'content' => ['required'],
            'is_required' => ['required'],
            'answers' => ['required','array','min:2'],
            'answers.*' => ['required'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Question,id'],
            'content' => ['required'],
            'is_required' => ['required'],
            'answers' => ['required','array','min:2'],
            'answers.*' => ['required'],
        ];
    }
}