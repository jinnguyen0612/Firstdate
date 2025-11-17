<?php

namespace App\Admin\Http\Requests\SupportCategory;

use App\Admin\Http\Requests\BaseRequest;

class SupportCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'title' => ['required', 'string'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\SupportCategory,id'],
            'title' => ['required', 'string'],
        ];
    }
}
