<?php

namespace App\Api\V1\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowAllUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatar' => $this->avatar?asset($this->avatar):null,
            'thumbnails' => $this->thumbnails ? array_map(fn($image) => asset($image), (array) $this->thumbnails) : [],
            'fullname' => $this->fullname,
            'age' => $this->birthday ? Carbon::parse($this->birthday)->age : null,
            'province_id' => $this->province_id,
            'province' => $this->province->name ?? null,
            'district_id' => $this->district_id,
            'district' => $this->district->name ?? null,
            'zodiac_sign' => $this->zodiac_sign->name ?? null,
            'gender' => $this->gender,
            'is_premium' => $this->is_premium(),
        ];
    }
}
