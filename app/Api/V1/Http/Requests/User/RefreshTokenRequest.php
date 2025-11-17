<?php

namespace App\Api\V1\Http\Requests\User;

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
