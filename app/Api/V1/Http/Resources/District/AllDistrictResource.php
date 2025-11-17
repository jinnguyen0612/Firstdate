<?php

namespace App\Api\V1\Http\Resources\District;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllDistrictResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($district){
            
            return [
                'id' => $district->id,
                'name' => $district->name,
            ];
            
        });
    }
}