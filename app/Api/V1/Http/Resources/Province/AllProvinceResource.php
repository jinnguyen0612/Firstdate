<?php

namespace App\Api\V1\Http\Resources\Province;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllProvinceResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($province){
            
            return [
                'id' => $province->id,
                'name' => $province->name,
            ];
            
        });
    }
}