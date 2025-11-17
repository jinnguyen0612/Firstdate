<?php

namespace App\Api\V1\Http\Requests\Question;

use App\Api\V1\Http\Requests\BaseRequest;

class QuestionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'limit' => ['nullable', 'integer', 'min:1'],
            'required' => ['nullable']
        ];
    }
}