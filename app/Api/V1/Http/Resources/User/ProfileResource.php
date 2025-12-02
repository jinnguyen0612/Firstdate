<?php

namespace App\Api\V1\Http\Resources\User;

use App\Admin\Traits\AuthService;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    use AuthService;
    public function toArray($request)
    {
        if ($this->getCurrentUserId() == null || $this->getCurrentUserId() != $this->id) {
            return [
                'id' => $this->id,
                'fullname' => $this->fullname,
                'email' => $this->email,
                'phone' => $this->phone,
                'min_age_find' => (float) $this->min_age_find,
                'max_age_find' => (float) $this->max_age_find,
                'district_id' => $this->district_id,
                'district' => optional($this->district)->name,
                'avatar' => $this->avatar ? asset($this->avatar) : null,
                'thumbnails' => $this->thumbnails ? collect($this->thumbnails)->map(fn($img) => asset($img))->all() : null,
                'birthday' => $this->birthday ?? null,
                'age' => $this->birthday ? $this->age() : null,
                'zodiac_sign' => $this->zodiac_sign,
                'gender' => $this->gender,
                'looking_for' => $this->looking_for,
                'answer' => collect($this->userAnswers)->map(function ($answer) {
                    return [
                        'question_id' => $answer['question']['id'] ?? null,
                        'question' => $answer['question']['content'] ?? null,
                        'answer_id' => $answer['answer']['id'] ?? null,
                        'answer' => $answer['answer']['answer'] ?? null,
                        'is_required' => $answer['question']['is_required'] ?? null,
                    ];
                }),
                'relationship' => $this->userRelationship,
                'datingTime' => $this->userDatingTimes,
                'status' => $this->status,
                'is_premium' => $this->is_premium(),
                'border_color' => $this->border_color,
                'is_subsidy_offer' => $this->is_subsidy_offer,
            ];
        }

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
            'birthday' => $this->birthday ?? null,
            'age' => $this->birthday ? $this->age() : null,
            'zodiac_sign' => $this->zodiac_sign,
            'min_age_find' => (float) $this->min_age_find,
            'max_age_find' => (float) $this->max_age_find,
            'gender' => $this->gender,
            'looking_for' => $this->looking_for,
            'wallet' => $this->wallet,
            'answer' => collect($this->userAnswers)->map(function ($answer) {
                return [
                    'question_id' => $answer['question']['id'] ?? null,
                    'question' => $answer['question']['content'] ?? null,
                    'answer_id' => $answer['answer']['id'] ?? null,
                    'answer' => $answer['answer']['answer'] ?? null,
                    'is_required' => $answer['question']['is_required'] ?? null,
                ];
            })->all(),
            'relationship' => $this->userRelationship,
            'datingTime' => $this->userDatingTimes,
            'status' => $this->status,
            'is_premium' => $this->is_premium(),
            'border_color' => $this->border_color,
            'is_subsidy_offer' => $this->is_subsidy_offer,
            'bank' => [
                'bank_name' => $this->bank_name,
                'bank_acc_name' => $this->bank_acc_name,
                'bank_acc_number' => $this->bank_acc_number,
                'bank_qr' => $this->bank_qr ? asset($this->bank_qr) : null
            ]
        ];
    }
}
