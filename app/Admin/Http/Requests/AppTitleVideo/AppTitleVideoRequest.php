<?php

namespace App\Admin\Http\Requests\AppTitleVideo;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class AppTitleVideoRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'titles' => ['required', 'array'],
            'titles.*.id' => ['required'],
            'titles.*.value' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-m4v', 'max:512000'],
        ];
    }
}
