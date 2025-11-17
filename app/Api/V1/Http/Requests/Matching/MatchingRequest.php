<?php

namespace App\Api\V1\Http\Requests\Matching;

use App\Api\V1\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class MatchingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet()
    {
        return [
            'limit' => ['nullable', 'integer', 'min:1'],
            'required' => ['nullable']
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'user_loved_id' => ['required', 'exists:App\Models\User,id'],
            'is_supper_love' => ['nullable'],
            'support_money' => ['nullable'],
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodDelete()
    {
        return [
            'user_id' => ['required', 'exists:App\Models\User,id'],
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $is_supper_love = $this->is_supper_love;
            $support_money = $this->support_money;

            if($this->isMethod('POST')){
                if($is_supper_love === 1){
                    if(empty($support_money) || $support_money <= 0){
                        $validator->errors()->add('support_money', 'support_money is required');
                    }
                }
            }
        });
    }
}
