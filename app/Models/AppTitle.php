<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppTitle extends Model
{
    use HasFactory;

    protected $table = 'app_titles';

    protected $guarded = [];

    protected $casts = [];

}