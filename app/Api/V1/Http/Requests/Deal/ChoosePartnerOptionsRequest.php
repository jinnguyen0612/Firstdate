<?php

namespace App\Api\V1\Http\Requests\Deal;

use App\Api\V1\Http\Requests\BaseRequest;

class ChoosePartnerOptionsRequest extends BaseRequest
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
            'partners' => ['required', 'array'],
            'partners.*' => ['required', 'exists:App\Models\Partner,id'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $partners = $this->input('partners');

            if(count($partners) != 5){
                $validator->errors()->add("partners", "Số lượng quận chọn phải là 5.");
            }
            
        });
    }
}