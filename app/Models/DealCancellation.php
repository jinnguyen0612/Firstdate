<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealCancellation extends Model
{
    use HasFactory;

    protected $table = 'deal_cancellations';

    protected $guarded = [];

    protected $casts = [];
    
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}