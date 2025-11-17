<?php

namespace App\Admin\Http\Requests\PartnerTable;

use App\Admin\Http\Requests\BaseRequest;

class PartnerTableRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'partner_id' => ['required', 'exists:App\Models\Partner,id'],
            'name' => ['required', 'string'],
        ];
    }

    protected function methodPut()
    {
        return [
            'id' => ['required', 'exists:App\Models\PartnerTable,id'],
            'name' => ['required', 'string'],
        ];
    }
}