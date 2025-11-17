<?php

namespace App\Api\V1\Http\Resources\Teacher;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class AllTeacherResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return $this->collection->map(function ($teacher) {
            return new ShowTeacherResource($teacher);
        });
    }
}
