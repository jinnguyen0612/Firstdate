<?php

namespace App\Http\Requests\Partner\Profile;

use App\Api\V1\Http\Requests\BaseRequest;

class ProfileRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'avatar' => ['nullable'],
            'name' => ['required'],
            'address' => ['required'],
            'district' => ['required'],
            'province' => ['required'],
            'lat' => ['nullable'],
            'lng' => ['nullable'],
            'description' => ['nullable'],
            'partner_category_id' => ['required'],
        ];
    }
}