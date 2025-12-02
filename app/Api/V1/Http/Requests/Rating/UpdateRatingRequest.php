<?php

namespace App\Api\V1\Http\Requests\Rating;

use App\Api\V1\Http\Requests\BaseRequest;

class UpdateRatingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function methodPost()
    {
        return [
            'id' => ['required', 'exists:App\Models\Rating,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string'],
        ];
    }
}
