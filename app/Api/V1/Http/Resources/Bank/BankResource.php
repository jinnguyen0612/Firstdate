<?php

namespace App\Api\V1\Http\Resources\Bank;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'shortName' => $this->shortName,
            'name' => $this->name,
        ];
    }
}
