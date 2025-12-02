<?php

namespace App\Api\V1\Http\Resources\Deal;

use App\Api\V1\Http\Resources\User\ShowAllUserResource;
use App\Api\V1\Http\Resources\User\UserResource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AllDealResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userMale' => ShowAllUserResource::make($this->user_male),
            'userFemale' => ShowAllUserResource::make($this->user_female),
            'status' => $this->status,
            'booking_status' => $this->booking? $this->booking->status : null,
            'deposit' => $this->booking? $this->booking->deposit : null,
        ];
    }
}
