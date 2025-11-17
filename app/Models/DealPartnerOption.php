<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DealPartnerOption extends Model
{
    use HasFactory;

    protected $table = 'deal_partner_options';

    protected $guarded = [];

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

}
