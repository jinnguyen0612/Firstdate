<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppCategory extends Model
{
    use HasFactory;

    protected $table = 'app_categories';

    protected $guarded = [];

    protected $casts = [];

}