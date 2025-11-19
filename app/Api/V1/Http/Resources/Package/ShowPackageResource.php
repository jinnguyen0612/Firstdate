<?php

namespace App\Api\V1\Http\Resources\Package;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowPackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'available_days' => $this->available_days,
            'description' => $this->description,
        ];
    }
}
