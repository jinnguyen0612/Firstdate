<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRelationship extends Model
{
    use HasFactory;

    protected $table = 'user_relationships';

    protected $fillable = [
        'user_id',
        'relationship',
    ];

}


