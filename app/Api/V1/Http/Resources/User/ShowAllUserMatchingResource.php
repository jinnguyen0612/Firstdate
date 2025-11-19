<?php

namespace App\Api\V1\Http\Resources\User;

use App\Admin\Traits\AuthService;
use App\Api\V1\Repositories\Deal\DealRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowAllUserMatchingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dealRepository = app(DealRepositoryInterface::class);
        $deal = $dealRepository->getDeal($this->id);

        return [
            'id' => $this->id,
            'avatar' => $this->avatar?asset($this->avatar):null,
            'thumbnails' => $this->thumbnails ? array_map(fn($image) => asset($image), (array) $this->thumbnails) : [],
            'fullname' => $this->fullname,
            'age' => $this->birthday ? Carbon::parse($this->birthday)->age : null,
            'province_id' => $this->province_id,
            'province' => $this->province->name ?? null,
            'district_id' => $this->district_id,
            'district' => $this->district->name ?? null,
            'zodiac_sign' => $this->zodiac_sign->name ?? null,
            'deal_id' => $deal->id??null,
            'gender' => $this->gender,
            'is_supper_love' => $this->is_supper_love===1?true:false,
            'support_money' => $this->support_money?(int) $this->support_money : null,
            'is_premium' => $this->is_premium()
        ];
    }
}
