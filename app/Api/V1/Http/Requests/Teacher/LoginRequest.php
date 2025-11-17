<?php

namespace App\Api\V1\Http\Requests\Teacher;

use App\Api\V1\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'exists:teachers,email'],
            'password' => 'required'
        ];
    }
}
