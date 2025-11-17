<?php

namespace App\Api\V1\Http\Resources\Session\Student;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentSessionDetailResource extends JsonResource
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
            'attendance_status' => $this->attendance->first()->status,
            'classroom' => [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
                'status' => $this->classroom->status,
                'teacher' => [
                    'id' => $this->classroom->teacher->id,
                    'fullname' => $this->classroom->teacher->fullname,
                    'email' => $this->classroom->teacher->email,
                    'phone' => $this->classroom->teacher->phone,
                ],
                'schedules' => $this->classroom->schedules->map(function ($schedule) {
                    return [
                        'value' => $schedule->weekday,
                        'name' => $schedule->weekday->description()
                    ];
                }),
            ],
        ];
    }
}
