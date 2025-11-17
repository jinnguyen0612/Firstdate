<?php

namespace App\Api\V1\Http\Requests\District;

use App\Api\V1\Http\Requests\BaseRequest;

class DistrictSearchRequest extends BaseRequest
{
    protected function methodGet()
    {
        return [
            'province_id' => ['required', 'exists:App\Models\Province,id'],
            'name' => ['nullable']
        ];
    }
}
