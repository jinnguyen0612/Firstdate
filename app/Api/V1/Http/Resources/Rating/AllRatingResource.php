<?php

namespace App\Api\V1\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class AllRatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Rating\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_fullname' => $this->user->fullname,
            'rating' => $this->rating,
        ];
    }
}
