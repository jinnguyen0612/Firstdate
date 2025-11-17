<?php

namespace App\Admin\Http\Requests\PartnerCategory;

use App\Admin\Http\Requests\BaseRequest;

class PartnerCategoryRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'name' => ['required', 'string'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\PartnerCategory,id'],
            'name' => ['required', 'string'],
        ];
    }
}