<?php

namespace App\Api\V1\Http\Resources\Session\Teacher;

use App\Enums\Attendance\AttendanceStatus;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherSessionDetailResource extends JsonResource
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
            'student_qty' => $this->attendance->count(),
            'present_students' => $this->attendance->where('status', AttendanceStatus::Present->value)->count(),
            'absent_students' => $this->attendance->where('status', AttendanceStatus::Absent->value)->count(),
            'classroom' => [
                'id' => $this->classroom->id,
                'name' => $this->classroom->name,
                'status' => $this->classroom->status,
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
