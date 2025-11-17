<?php

namespace App\Admin\Http\Requests\AppTitle;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class AppTitleRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'titles' => ['required', 'array'],
            'titles.*.id' => ['required'],
            'titles.*.value' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'titles.*.value' => 'Tiêu đề hiển thị không được để trống.',
        ];
    }

}