<?php

namespace App\Models;

use App\Enums\Notification\NotificationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends  Model
{
    use HasFactory;
    protected $table = 'notifications';

    protected $fillable = [
        // 'user_sender_id',
        'user_id',
        'partner_id',
        'title',
        'image',
        'short_message',
        'message',
        'status',
        'read_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected $casts = [
        'status' => NotificationStatus::class,
    ];
    public function markAsRead(): void
    {
        $this->status = NotificationStatus::READ;
        $this->read_at = now();
        $this->save();
    }
}
