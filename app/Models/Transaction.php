<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $guarded = [];

    protected $casts = [];

    protected $fillable = [
        'code', 
        'from_id', 
        'from_type', 
        'from_name',
        'to_id', 
        'to_type', 
        'to_name',
        'amount', 
        'type', 
        'status', 
        'transaction_type', 
        'description', 
        'image',
        'payos_order_code',
    ];

    public function from()
    {
        return $this->morphTo();
    }

    public function to()
    {
        return $this->morphTo();
    }


}