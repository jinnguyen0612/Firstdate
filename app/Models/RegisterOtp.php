<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterOTP extends Model
{
    use HasFactory;

    protected $table = 'register_otp';

    protected $guarded = [];

    protected $casts = [];

}