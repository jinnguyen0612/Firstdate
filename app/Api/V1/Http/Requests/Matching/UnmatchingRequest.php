<?php

namespace App\Api\V1\Http\Requests\Matching;

use App\Api\V1\Http\Requests\BaseRequest;

class UnmatchingRequest extends BaseRequest
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