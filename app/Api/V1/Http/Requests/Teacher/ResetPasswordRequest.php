<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;

class ResetPasswordRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'exists:App\Models\Teacher,email']
        ];
    }
}
