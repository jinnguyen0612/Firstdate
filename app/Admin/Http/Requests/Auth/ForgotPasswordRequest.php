<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class ForgotPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'email' => 'required|email',
        ];
    }

    protected function methodPost()
    {
        return [
            'email' => 'required|email',
        ];
    }

    protected function methodPut()
    {
        return [
            'token_get_password' => 'required',
            'password' => 'required|string',
            'confirm' => 'required|string|same:password',
        ];
    }
}