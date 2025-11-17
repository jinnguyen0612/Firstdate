<?php

namespace App\Admin\Services\Question;

use App\Admin\Repositories\Answer\AnswerRepositoryInterface;
use App\Admin\Services\Question\QuestionServiceInterface;
use  App\Admin\Repositories\Question\QuestionRepositoryInterface;
use Illuminate\Http\Request;
use App\Admin\Traits\Setup;

class QuestionService implements QuestionServiceInterface
{
    use Setup;
    /**
     * Current Object instance
     *
     * @var array
     */
    protected $data;
    
    protected $repository;

    public function __construct(QuestionRepositoryInterface $repository,
                                protected AnswerRepositoryInterface $answerRepository)
    {
        $this->repository = $repository;
    }
    
    public function store(Request $request){
        $this->data = $request->validated();

        $question = [
            'content' => $this->data['content'],
            'is_required' => $this->data['is_required'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $question = $this->repository->create($question);

        foreach ($this->data['answers'] as $answer) {
            $question->answers()->create([
                'answer' => $answer['answer'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return $question;
    }

    public function update(Request $request){
        $this->data = $request->validated();

        $questionRequest = [
            'content' => $this->data['content'],
            'is_required' => $this->data['is_required'],
            'updated_at' => now(),
        ];

        $question = $this->repository->findOrFail($this->data['id']);
        
        $data = $question->update($questionRequest);

        $submittedIds = collect($this->data['answers'])->pluck('id')->filter()->all(); // Bỏ null

        $question->answers()->whereNotIn('id', $submittedIds)->delete();

        foreach ($this->data['answers'] as $answer) {
            if (!empty($answer['id'])) {
                $question->answers()->where('id', $answer['id'])->update([
                    'answer' => $answer['answer'],
                    'updated_at' => now(),
                ]);
            }else{
                $question->answers()->create([
                    'answer' => $answer['answer'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return $data;
    }

    public function delete($id){
        return $this->repository->delete($id);

    }

}