<?php

namespace App\Admin\Http\Requests\Auth;

use App\Admin\Http\Requests\BaseRequest;

class OauthReqest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'code' => 'required|exists:users,code',
        ];
    }
    protected function methodPost()
    {
        return [
            'code' => 'required',
            'token_active_account' => 'required|numeric',
        ];
    }
}
