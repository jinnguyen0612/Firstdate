<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Enums\User\{
    Gender,
    LookingFor,
    UserStatus,
    ZodiacSign,
};
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'fullname',
        'gender',
        'birthday',
        'zodiac_sign',
        'province_id',
        'district_id',
        'reroll',
        'pin',
        'lat',
        'lng',
        'min_age_find',
        'max_age_find',
        'looking_for',
        'dating_time_from',
        'dating_time_to',
        'avatar',
        'thumbnails',
        'description',
        'bank_acc_name',
        'bank_name',
        'bank_acc_number',
        'wallet',
        'email',
        'phone',
        'token_active_account',
        'token_expiration',
        'is_hide',
        'remember_token',
        'created_at',
        'updated_at',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'token_expiration' => 'datetime',
        'phone_otp_expiration' => 'datetime',
        'suggested_questions' => 'array',
        'answers' => 'array',
        'birthday' => 'date',
        'thumbnails' => AsArrayObject::class,
        'gender' => Gender::class,
        'looking_for' => LookingFor::class,
        'zodiac_sign' => ZodiacSign::class,
        'active' => 'boolean',
        'status' => UserStatus::class,
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->avatar)) {
                $user->avatar = 'public/assets/images/default-avatar.png'; // Default value for avatar
            }
        });
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
            ->withPivot('model_type')
            ->wherePivot('model_type', self::class);
    }

    public function checkPermissions($permissionsArr): bool
    {
        foreach ($permissionsArr as $permission) {
            if ($this->can($permission)) {
                return true;
            }
        }
        return false;
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')
            ->orderByRaw('read_at IS NOT NULL, id DESC');
    }

    public function unreadNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->where('read_at', null)->orderBy('id', 'desc');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function age()
    {
        if ($this->birthday) {
            return $this->birthday->diffInYears(now());
        }

        return $this->age; // Return stored age value if birthday not set
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'user_id');
    }

    public function userDatingTimes()
    {
        return $this->hasMany(UserDatingTime::class, 'user_id');
    }

    public function userRelationship()
    {
        return $this->hasMany(UserRelationship::class, 'user_id');
    }
}
