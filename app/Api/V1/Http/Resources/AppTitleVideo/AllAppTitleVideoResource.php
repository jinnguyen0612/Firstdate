<?php

namespace App\Api\V1\Http\Resources\AppTitleVideo;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllAppTitleVideoResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\AppTitleVideo\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($hobby) {
            return new ShowAppTitleVideoResource($hobby);
        });
    }
}