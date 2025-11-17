<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $guarded = [];

    protected $casts = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_answer', 'question_id', 'user_id');
    }
    
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'question_id');
    }
}