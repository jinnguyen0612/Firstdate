<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matching extends Model
{
    use HasFactory;
    protected $table = 'matchings';
	protected $guarded = [];
	protected $casts = [];

    // Người gửi yêu thích
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Người được yêu thích
    public function lovedUser()
    {
        return $this->belongsTo(User::class, 'user_loved_id');
    }
}
