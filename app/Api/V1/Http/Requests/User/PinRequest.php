<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\Gender;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Enum;

class PinRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'pin' => ['required', 'string', 'min:6', 'max:6'],
        ];
    }

}
