<?php

namespace App\Api\V1\Http\Requests\Transaction;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Notification\NotificationStatus;
use App\Enums\Transaction\TransactionType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TransactionRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function methodGet(): array
    {
        return [
            'limit' => ['nullable'],
            'type'  => ['nullable', Rule::in([
                'received',
                'payment',
                'withdraw',
            ])],
        ];
    }
}
