<?php

namespace App\Api\V1\Http\Resources\Partner;

use Illuminate\Http\Resources\Json\JsonResource;

class AllPartnerResource extends JsonResource
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
            'name' => $this->name,
            'avatar' => $this->avatar ? asset($this->avatar) : null,
            'gallery' => $this->gallery ? collect($this->gallery)->map(fn($img) => asset($img))->all() : null,
            'address' => $this->address,
            'district' => $this->district ? $this->district->name : null,
            'category' => $this->partner_category ? $this->partner_category->name : null
        ];
    }
}
