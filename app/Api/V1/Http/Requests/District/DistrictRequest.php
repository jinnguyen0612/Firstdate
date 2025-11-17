<?php

namespace App\Api\V1\Http\Requests\District;

use App\Api\V1\Http\Requests\BaseRequest;

class DistrictRequest extends BaseRequest
{
    protected function methodGet()
    {
        return [
            'provinceId' => ['required', 'exists:App\Models\Province,id'],
        ];
    }
}
