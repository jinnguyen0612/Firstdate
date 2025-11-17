<?php

namespace App\Api\V1\Http\Resources\AppTitle;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowAppTitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\AppTitle\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
            'value' => $this->value
        ];
    }
}
