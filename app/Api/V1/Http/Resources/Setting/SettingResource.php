<?php

namespace App\Api\V1\Http\Resources\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    public function toArray($request)
    {

        $data =  [
            'setting_key' => $this->setting_key,
            'setting_name' => $this->setting_name,
            'plain_value' => $this->plain_value,
        ];
        return $data;
    }
}
