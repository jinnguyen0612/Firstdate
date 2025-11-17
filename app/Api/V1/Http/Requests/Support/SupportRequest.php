<?php

namespace App\Api\V1\Http\Requests\Support;

use App\Api\V1\Http\Requests\BaseRequest;

class SupportRequest extends BaseRequest
{
    protected function methodGet()
    {
        return [
            'category_id' => ['nullable', 'integer', 'exists:support_categories,id'],
            'limit' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string']
        ];
    }
}
