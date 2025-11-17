<?php

namespace App\Api\V1\Http\Requests\Bank;

use App\Api\V1\Http\Requests\BaseRequest;

class BankRequest extends BaseRequest
{
    protected function methodGet()
    {
        return [
            'limit' => ['nullable', 'integer', 'min:1'],
            'search' => ['nullable', 'string']
        ];
    }
}
