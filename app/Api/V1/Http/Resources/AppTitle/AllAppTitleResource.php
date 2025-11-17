<?php

namespace App\Api\V1\Http\Resources\AppTitle;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllAppTitleResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\AppTitle\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($hobby) {
            return new ShowAppTitleResource($hobby);
        });
    }
}