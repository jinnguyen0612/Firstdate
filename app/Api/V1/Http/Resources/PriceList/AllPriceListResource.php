<?php

namespace App\Api\V1\Http\Resources\PriceList;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllPriceListResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\PriceList\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($hobby) {
            return new ShowPriceListResource($hobby);
        });
    }
}
