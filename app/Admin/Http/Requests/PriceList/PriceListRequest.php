<?php

namespace App\Admin\Http\Requests\PriceList;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class PriceListRequest extends BaseRequest
{
    protected function methodPost()
    {
        return [
            'price' => ['required'],
            'value' => ['required'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\PriceList,id'],
            'price' => ['required'],
            'value' => ['required'],
        ];
    }

}