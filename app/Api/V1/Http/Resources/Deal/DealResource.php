<?php

namespace App\Api\V1\Http\Resources\Deal;

use App\Api\V1\Http\Resources\User\ShowAllUserResource;
use App\Api\V1\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userMale' => ShowAllUserResource::make($this->user_male),
            'userFemale' => ShowAllUserResource::make($this->user_female),
            'dealDistrictOptions' => $this->dealDistrictOptions
                ? $this->dealDistrictOptions->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'district_id' => $item->district_id,
                        'district_name' => $item->district ? $item->district->name : null,
                        'is_chosen' => $item->is_chosen
                    ];
                })
                : null,
            'dealDateOptions' => $this->dealDateOptions
                ? $this->dealDateOptions->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'date' => $item->date,
                        'from' => $item->from,
                        'to' => $item->to,
                        'is_chosen' => $item->is_chosen
                    ];
                })
                : null,
            'dealPartnerOptions' => $this->dealPartnerOptions
                ? $this->dealPartnerOptions->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'partner_id' => $item->partner_id,
                        'partner_name' => $item->partner ? $item->partner->name : null,
                        'is_chosen' => $item->is_chosen
                    ];
                })
                : null,
            'status' => $this->status,
            'booking' => $this->booking
        ];
    }
}
