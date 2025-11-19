<?php

namespace App\Admin\Http\Requests\Package;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class PackageRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'discount_price' => ['nullable'],
            'available_days' => ['required'],
            'description' => ['nullable'],
            'is_active' => ['required'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Package,id'],
            'name' => ['required'],
            'price' => ['required'],
            'discount_price' => ['nullable'],
            'available_days' => ['required'],
            'description' => ['nullable'],
            'is_active' => ['nullable'],
        ];
    }

}
