<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';

    protected $guarded = [];

    protected $casts = [];

    public function supportCategory()
    {
        return $this->belongsTo(SupportCategory::class, 'support_category_id');
    }
}
