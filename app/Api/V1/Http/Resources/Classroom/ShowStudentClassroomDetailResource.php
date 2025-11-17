<?php

namespace App\Api\V1\Http\Resources\Classroom;

use App\Enums\Session\SessionStatus;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowStudentClassroomDetailResource extends JsonResource
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
            'max_students' => count($this->students) .' / '. $this->max_students,
            'is_full' => $this->is_full?'Đã đủ học sinh':'Chưa đủ học sinh',
            'status' => $this->status,
            'teacher' => [
                'id' => $this->teacher_id,
                'fullname' => $this->teacher->fullname,
            ],
            'start_date' => format_date($this->start_date),
            'students' => $this->students->map(function ($student){
                return [
                    'id' => $student->id,
                    'fullname' => $student->fullname,
                ];
            }),
            'sessions' => $this->sessions->map(function ($session) {
                return [
                    'id' => $session->id,
                    'date' => $session->date,
                    'start' => $session->start,
                    'end' => $session->end,
                    'content' => $session->content,
                    'status' => $session->status,
                    'attendance' => $session->attendance,
                ];
            }),
            'schedule' => $this->schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'weekday' => $schedule->weekday,
                    'start' => $schedule->start,
                    'end' => $schedule->end,
                ];
            }),
            'session_qty' => $this->session_qty,
            'remaining_sessions' => $this->sessions
            ->filter(fn($item) => $item->status === SessionStatus::Pending->value)
            ->count(),
        ];
    }
}
