<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileMonthly extends Model
{
    use HasFactory;

    protected $table = 'profile_monthly';

    protected $guarded = [];

    protected $casts = [];

}