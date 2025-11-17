<?php

namespace App\Api\V1\Http\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this['question']['id'],
            'question_content' => $this['question']['content'],
            'answer' => $this['answer'],
            'is_required' => $this['question']['is_required'],
        ];
    }
}