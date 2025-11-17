<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $guarded = [];

    protected $casts = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
}