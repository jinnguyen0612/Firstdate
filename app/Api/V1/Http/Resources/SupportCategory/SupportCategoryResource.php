<?php

namespace App\Api\V1\Http\Resources\SupportCategory;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportCategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
