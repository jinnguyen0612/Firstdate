<?php

namespace App\Admin\Http\Requests\Transaction;

use App\Admin\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class TransactionRequest extends BaseRequest
{
    protected function methodPut(): array
    {
        return [
            'id' => ['required', 'exists:App\Models\Transaction,id'],
            'status' => ['required'],
        ];
    }

}