<?php

namespace App\Api\V1\Http\Resources\Session\Classroom;

use App\Models\Student;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AllSessionsDateResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return $this->collection
            ->pluck('date')      
            ->unique()         
            ->values()     
            ->toArray();
    }
}
