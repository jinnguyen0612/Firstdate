<?php

namespace App\Admin\Http\Resources\Partner;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerSearchSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => 'Tên đối tác: ' . $this->name .
                ' | SDT: ' . ($this->phone ?: 'Không có') .
                ' | Email: ' . ($this->email ?: 'Không có')
        ];
    }
}
