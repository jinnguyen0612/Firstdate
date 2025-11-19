<?php

namespace App\Api\V1\Http\Requests\Partner;

use App\Api\V1\Http\Requests\BaseRequest;

class PartnerRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'district_id' => ['required', 'integer', 'min:1'],
            'search' => ['nullable', 'string'],
            'limit' => ['nullable', 'integer', 'min:1']
        ];
    }

}
