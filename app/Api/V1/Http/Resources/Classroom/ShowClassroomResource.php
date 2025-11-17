<?php

namespace App\Api\V1\Http\Resources\Classroom;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowClassroomResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'max_students' => count($this->students) .' - '. $this->max_students,
            'is_full' => $this->is_full,
            'status' => $this->status,
            'teacher' => [
                'id' => $this->teacher_id,
                'fullname' => $this->teacher->fullname,
            ],
            'session_qty' => $this->session_qty,
            'start_date' => $this->start_date,
            'schedule' => $this->schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'weekday' => $schedule->weekday,
                    'start' => $schedule->start,
                    'end' => $schedule->end,
                ];
            }),
            
        ];
    }
}
