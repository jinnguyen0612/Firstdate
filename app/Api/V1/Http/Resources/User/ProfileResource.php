<?php

namespace App\Api\V1\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'district_id' => $this->district_id,
            'district' => optional($this->district)->name,
            'reroll' => $this->reroll,
            'avatar' => $this->avatar ? asset($this->avatar) : null,
            'thumbnails' => $this->thumbnails ? collect($this->thumbnails)->map(fn($img) => asset($img))->all() : null,
            'birthday' => $this->birthday?? null,
            'age' => $this->birthday ? $this->age(): null,
            'zodiac_sign' => $this->zodiac_sign,
            'gender' => $this->gender,
            'looking_for' => $this->looking_for,
            'wallet' => $this->wallet,
            'answer' => collect($this->userAnswers)->map(function ($answer) {
                return [
                    'question_id' => $answer['question']['id'] ?? null,
                    'question' => $answer['question']['content'] ?? null,
                    'is_required' => $answer['question']['is_required'] ?? null,
                    'answer' => $answer['answer']['answer'] ?? null,
                ];
            })->all(),
            'relationship' => $this->userRelationship,
            'datingTime' => $this->userDatingTimes,
            'status' => $this->status,
        ];
    }
}
