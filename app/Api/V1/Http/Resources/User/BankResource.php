<?php

namespace App\Api\V1\Http\Resources\User;

use App\Admin\Traits\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    use AuthService;
    public function toArray($request)
    {
        return [
            'bank_name' => $this->bank_name,
            'bank_acc_name' => $this->bank_acc_name,
            'bank_acc_number' => $this->bank_acc_number,
            'bank_qr' => $this->bank_qr ? asset($this->bank_qr) : null
        ];
    }
}
