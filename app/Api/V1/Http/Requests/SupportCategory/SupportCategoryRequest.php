<?php

namespace App\Api\V1\Http\Requests\SupportCategory;

use App\Api\V1\Http\Requests\BaseRequest;

class SupportCategoryRequest extends BaseRequest
{
    protected function methodGet()
    {
        return [
            'limit' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string']
        ];
    }
}
