<?php

namespace App\Api\V1\Http\Requests\PriceList;

use App\Api\V1\Http\Requests\BaseRequest;

class GetPriceListRequest extends BaseRequest
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
