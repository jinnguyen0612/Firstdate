<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class StaffLoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'code' => 'required',
            'password' => 'required',
        ];
    }
}
