<?php

namespace App\Api\V1\Http\Resources\PriceList;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowPriceListResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'value' => $this->value
        ];
    }
}
