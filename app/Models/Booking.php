<?php

namespace App\Models;

use App\Enums\Booking\BookingAttendanceType;
use App\Enums\User\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $guarded = [];

    protected $casts = [];
    
    public function user_female()
    {
        return $this->belongsTo(User::class, 'user_female_id');
    }

    public function user_male()
    {
        return $this->belongsTo(User::class, 'user_male_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function table()
    {
        return $this->belongsTo(PartnerTable::class, 'partner_table_id');
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(BookingDeposit::class);
    }

    public function depositForUser($userId)
    {
        return $this->deposits()
            ->where('user_id', $userId)
            ->value('amount') ?? 0;
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(BookingAttendance::class);
    }

    public function hasUserAttended($userId)
    {
        return $this->attendance()->where('user_id', $userId)->where('type', BookingAttendanceType::Attended->value)->first();
    }

    public function bothAttendanceStatus(): array
    {
        return [
            'male' => $this->hasUserAttended($this->user_male_id),
            'female' => $this->hasUserAttended($this->user_female_id),
        ];
    }

    // Tổng tiền cọc
    public function totalDeposit(): float
    {
        return $this->deposits->sum('amount');
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function invoice():HasOne
    {
        return $this->hasOne(Invoice::class, 'booking_id');
    }

    public function getDepositNumber($userId)
    {
        if($this->user_male->gender == $this->user_female->gender ||
            $this->user_male->gender == Gender::Other->value ||
            $this->user_female->gender == Gender::Other->value){
            return admin_setting('lgbt_deposit_rate',0);
        }else{
            if($this->user_male_id == $userId){
                return admin_setting('male_deposit_rate',0);
            }else{
                return admin_setting('female_deposit_rate',0);
            }
        }
    }

}