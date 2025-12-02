<?php

namespace App\Api\V1\Http\Resources\Transaction;

use App\Enums\Transaction\TransactionType;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Transaction\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'from' => $this->from ? $this->from->fullname : 'Firstdate',
            'to' => $this->to? $this->to->fullname : 'Firstdate',
            'amount' => $this->amount,
            'description' => $this->description,
            'status' => $this->status,
            'type' => TransactionType::getDescription($this->type),
            'created_at' => $this->created_at,
        ];
    }
}
