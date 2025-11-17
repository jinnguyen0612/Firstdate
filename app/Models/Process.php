<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $table = 'processes';

    protected $guarded = [];

    protected $casts = [];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}