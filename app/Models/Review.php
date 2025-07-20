<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'booking_id',
        'rating',
        'comment',
        'rating_categories',
        'photos',
        'is_anonymous'
    ];

    protected $casts = [
        'rating_categories' => 'array',
        'photos' => 'array',
        'is_anonymous' => 'boolean'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_anonymous', false);
    }

    public function scopeWithRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        if (!$this->rating_categories) {
            return $this->rating;
        }

        return collect($this->rating_categories)->avg();
    }
}
