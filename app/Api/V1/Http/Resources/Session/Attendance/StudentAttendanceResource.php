<?php

namespace App\Api\V1\Http\Resources\Session\Attendance;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentAttendanceResource extends JsonResource
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
            'student_qty' => $this->attendance->count(),
            'attendance' => $this->attendance
                ->sortBy(function ($item) {
                    // Tách tên đầy đủ thành mảng và lấy phần tên (cuối cùng)
                    $parts = explode(' ', trim($item->student->fullname));
                    return mb_strtolower(end($parts)); // dùng mb_strtolower để chuẩn unicode
                })
                ->map(function ($item) {
                    return [
                        'id' => $item->student->id,
                        'fullname' => $item->student->fullname ?? null,
                        'status' => $item->status,
                    ];
                }),
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
