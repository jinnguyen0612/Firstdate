<?php

namespace App\Api\V1\Http\Resources\Session\Classroom;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherClassroomSessionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'start' => $this->start,
            'end' => $this->end,
            'status' => $this->status,
            'content' => $this->content,
            'classroom' => [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
                'status' => $this->classroom->status,
            ],
        ];
    }
}
