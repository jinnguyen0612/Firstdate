<?php

namespace App\Api\V1\Http\Resources\Session\Teacher;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionStatsResource extends JsonResource
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
            'total_pending' => $this->total_pending ?? 0,
            'pending_this_week' => $this->pending_this_week ?? 0
        ];
    }
}
