<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerTable extends Model
{
    use HasFactory;

    protected $table = 'partner_tables';

    protected $guarded = [];

    protected $casts = [];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }

}