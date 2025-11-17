<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Deal extends Model
{
    use HasFactory;

    protected $table = 'deals';

    protected $guarded = [];

    public function user_female(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_female_id');
    }

    public function user_male(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_male_id');
    }

    public function dealDistrictOptions(): HasMany
    {
        return $this->hasMany(DealDistrictOption::class);
    }

    public function dealDateOptions(): HasMany
    {
        return $this->hasMany(DealDateOption::class);
    }

    public function dealPartnerOptions(): HasMany
    {
        return $this->hasMany(DealPartnerOption::class);
    }

    public function dealCancellation(): HasMany
    {
        return $this->hasMany(DealCancellation::class);
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }

    public function dealTime(): HasOne
    {
        return $this->hasOne(DealDateOption::class)->where('is_chosen', 1);
    }
}
