<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isProvider()
    {
        return $this->role === 'provider';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteServices()
    {
        return $this->belongsToMany(Service::class, 'favorites');
    }

    public function customerConversations()
    {
        return $this->hasMany(Conversation::class, 'customer_id');
    }

    public function providerConversations()
    {
        return $this->hasMany(Conversation::class, 'provider_id');
    }

    public function conversations()
    {
        return $this->customerConversations()->union($this->providerConversations());
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Helper methods
    public function hasFavorited($serviceId)
    {
        return $this->favorites()->where('service_id', $serviceId)->exists();
    }

    public function hasReviewed($bookingId)
    {
        return $this->reviews()->where('booking_id', $bookingId)->exists();
    }

    public function getUnreadMessagesCount()
    {
        return Message::whereHas('conversation', function ($query) {
            $query->where('customer_id', $this->id)
                ->orWhere('provider_id', $this->id);
        })
            ->where('sender_id', '!=', $this->id)
            ->whereNull('read_at')
            ->count();
    }
}
