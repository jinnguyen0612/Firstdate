<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'user_answer';

    protected $fillable = [
        'question_id',
        'answer_id', // có thể null nếu là trả lời tự do
        'user_id',
        'answer',    // text nếu là tự do
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


