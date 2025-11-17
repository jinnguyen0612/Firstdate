<?php

namespace App\Api\V1\Http\Resources\AppTitleVideo;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowAppTitleVideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\AppTitleVideo\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
            'value' => asset($this->value)
        ];
    }
}