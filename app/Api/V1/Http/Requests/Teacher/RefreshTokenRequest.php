<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;

class RefreshTokenRequest extends BaseRequest
{
    protected function methodPost(): array
    {
        return [
            'refresh_token' => 'required',
        ];
    }
}
