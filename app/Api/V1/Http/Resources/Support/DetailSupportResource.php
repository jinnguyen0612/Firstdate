<?php

namespace App\Api\V1\Http\Resources\Support;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailSupportResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => $this->image ? asset($this->image) : null,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
