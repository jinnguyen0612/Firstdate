<?php

namespace App\Admin\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminSearchSelectResource extends JsonResource
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
