<?php

namespace App\Api\V1\Http\Requests\Deal;

use App\Api\V1\Http\Requests\BaseRequest;

class ChooseDistrictOptionsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'id' => ['required', 'exists:App\Models\Deal,id'],
            'districts' => ['required', 'array'],
            'districts.*' => ['required', 'exists:App\Models\District,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $districts = $this->input('districts');

            if(count($districts) != 5){
                $validator->errors()->add("districts", "Số lượng quận chọn phải là 5.");
            }
            
        });
    }
}