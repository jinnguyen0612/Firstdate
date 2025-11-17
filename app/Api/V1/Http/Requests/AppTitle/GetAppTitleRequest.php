<?php

namespace App\Api\V1\Http\Requests\AppTitle;

use App\Api\V1\Http\Requests\BaseRequest;

class GetAppTitleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'key' => ['nullable'],
        ];
    }
}