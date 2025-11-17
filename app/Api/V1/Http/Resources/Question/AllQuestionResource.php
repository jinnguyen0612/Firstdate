<?php

namespace App\Api\V1\Http\Resources\Question;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AllQuestionResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function($question) {
            return [
                'id' => $question->id,
                'question_content' => $question->content,
                'is_required' => $question->is_required
            ];
        });
    }
}