<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Partner extends Authenticatable
{
    use HasRoles;
    use HasFactory;

    protected $table = 'partners';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'token_expiration' => 'datetime',
        'phone_otp_expiration' => 'datetime',
        'gallery' => AsArrayObject::class,
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'model_has_roles',  'model_id', 'role_id');
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

    public function partner_category(): BelongsTo
    {
        return $this->belongsTo(PartnerCategory::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function partner_table():HasMany
    {
        return $this->hasMany(PartnerTable::class);
    }
}
