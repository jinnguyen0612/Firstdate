<?php

namespace App\Api\V1\Http\Resources\Package;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllPackageResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Package\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($hobby) {
            return new ShowPackageResource($hobby);
        });
    }
}
