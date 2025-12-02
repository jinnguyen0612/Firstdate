<?php

namespace App\Api\V1\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowRatingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_fullname' => $this->user->fullname,
            'rating' => $this->rating,
            'review' => $this->review,
        ];
    }
}
