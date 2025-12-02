<?php

namespace App\Api\V1\Http\Resources\Deal;

use App\Api\V1\Http\Resources\User\ShowAllUserResource;
use App\Api\V1\Http\Resources\User\UserResource;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    public function toArray($request)
    {
        $system_support_rate = Setting::where('setting_key', 'transportation_support_rate')->first()->plain_value;
        $booking = $this->booking ? $this->booking->load('deposits') : null;
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
                        'partner_avatar' => $item->partner ? ($item->partner->avatar? asset($item->partner->avatar) : null) : null,
                        'partner_name' => $item->partner ? $item->partner->name : null,
                        'partner_category' => $item->partner ? $item->partner->partner_category?->name : null,
                        'partner_address' => $item->partner ? $item->partner->address : null,
                        'is_chosen' => $item->is_chosen
                    ];
                })
                : null,
            'status' => $this->status,
            'booking' => $booking,
            'system_support_rate' => (int) $system_support_rate,
        ];
    }
}
