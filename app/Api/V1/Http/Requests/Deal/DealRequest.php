<?php

namespace App\Api\V1\Http\Requests\Deal;

use App\Api\V1\Http\Requests\BaseRequest;
use App\Enums\Booking\BookingStatus;
use App\Enums\Deal\DealStatus;
use Illuminate\Validation\Rules\Enum;

class DealRequest extends BaseRequest
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
            'status' => ['nullable']
        ];
    }
}
