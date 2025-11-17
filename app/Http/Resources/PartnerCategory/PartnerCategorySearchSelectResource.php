<?php

namespace App\Http\Resources\Partner\PartnerCategory;


use Illuminate\Http\Resources\Json\JsonResource;

class PartnerCategorySearchSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->name
        ];
    }
}
