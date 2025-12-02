<?php

namespace App\Admin\Http\Requests\AppTitleVideo;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class AppTitleVideoRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'id' => ['required'],
            'value' => ['nullable', 'string'],
        ];
    }
}
