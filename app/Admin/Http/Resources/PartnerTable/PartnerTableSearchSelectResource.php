<?php

namespace App\Admin\Http\Resources\PartnerTable;

use Illuminate\Http\Resources\Json\JsonResource;

class PartnerTableSearchSelectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => 'Bàn: Mã ' . $this->code . ' - Tên ' . $this->name,
        ];
    }
}
