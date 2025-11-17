<?php

namespace App\Api\V1\Http\Resources\Teacher;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTeacherDetailResource extends JsonResource
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
            'fullname' => $this->fullname,
            'avatar' => asset($this->avatar),
            'classrooms' => $this->classrooms->map(function ($classroom){
                return [
                    'id' => $classroom->id,
                    'name' => $classroom->name,
                    'max_students' => count($classroom->students) .' - '. $classroom->max_students,
                    'schedule' => $classroom->schedules->map(function ($schedule) {
                        return [
                            'id' => $schedule->id,
                            'weekday' => $schedule->weekday,
                            'start' => $schedule->start,
                            'end' => $schedule->end,
                        ];
                    }),
                ];
            }),
        ];
    }
}
