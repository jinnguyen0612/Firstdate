<?php

namespace App\Admin\Http\Resources\PartnerCategory;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerCategorySearchSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => 'Loại đối tác: ' . $this->name
        ];
    }
}
