<?php

namespace App\Admin\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSearchSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => 'Họ tên: ' . $this->fullname .
                ' | SDT: ' . ($this->phone ?: 'Không có') .
                ' | Email: ' . ($this->email ?: 'Không có')
        ];
    }
}
