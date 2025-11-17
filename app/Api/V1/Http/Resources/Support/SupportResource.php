<?php

namespace App\Api\V1\Http\Resources\Support;

use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
