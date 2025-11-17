<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;

class ResetPasswordRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'email' => ['required', 'exists:App\Models\User,email']
        ];
    }
}
