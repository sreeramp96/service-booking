<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'message',
        'attachments',
        'read_at'
    ];

    protected $casts = [
        'attachments' => 'array',
        'read_at' => 'datetime'
    ];

    // Relationships
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('conversation', function ($q) use ($userId) {
            $q->where('customer_id', $userId)
                ->orWhere('provider_id', $userId);
        });
    }

    // Helper methods
    public function markAsRead()
    {
        if (!$this->read_at) {
            $this->update(['read_at' => now()]);
        }
    }

    public function isFromUser($userId)
    {
        return $this->sender_id === $userId;
    }
}
