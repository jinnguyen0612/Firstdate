<?php

namespace App\Api\V1\Http\Resources\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray($request)
    {

        $data =  [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'avatar' => asset($this->avatar),
            'birthday' => $this->birthday,
            'gender' => $this->gender,
        ];
        return $data;
    }
}
