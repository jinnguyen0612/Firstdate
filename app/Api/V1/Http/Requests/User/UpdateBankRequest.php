<?php

namespace App\Api\V1\Http\Requests\User;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\User\Gender;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Enum;

class UpdateBankRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodPost()
    {
        return [
            'bank_qr' => ['required'],
            'bank_name' => ['required', 'string'],
            'bank_acc_name' => ['required', 'string'],
            'bank_acc_number' => ['required', 'string'],
        ];
    }

}
