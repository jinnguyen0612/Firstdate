<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDatingTime extends Model
{
    use HasFactory;

    protected $table = 'user_dating_times';

    protected $fillable = [
        'user_id',
        'dating_time',
    ];

}


