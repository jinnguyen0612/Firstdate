<?php

namespace App\Admin\Http\Requests\Support;

use App\Admin\Http\Requests\BaseRequest;

class SupportRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'support_category_id' => ['required', 'exists:App\Models\SupportCategory,id'],
            'image' => ['nullable'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\Support,id'],
            'image' => ['nullable'],
            'title' => ['required', 'string'],
            'content' => ['required', 'string'],
        ];
    }
}
