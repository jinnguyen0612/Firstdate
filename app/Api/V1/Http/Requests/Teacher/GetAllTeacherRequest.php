<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;

class GetAllTeacherRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'search' => ['nullable'],
            'limit' => ['nullable', 'integer', 'min:1']
        ];
    }
}