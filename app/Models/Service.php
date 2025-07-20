<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    // NEW: Add this relationship - this is what was missing!
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Review system relationships
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Favorites system relationships
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    // Messages system relationships
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    // Helper methods and attributes
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function getBookingsCountAttribute()
    {
        return $this->bookings()->count();
    }

    public function isFavoritedBy($userId)
    {
        return $this->favorites()->where('user_id', $userId)->exists();
    }

    public function canBeReviewedBy($userId)
    {
        return $this->bookings()
            ->where('user_id', $userId)
            ->where('status', 'confirmed')
            ->whereDoesntHave('review')
            ->exists();
    }

    // Scopes
    public function scopeWithAverageRating($query)
    {
        return $query->withAvg('reviews', 'rating');
    }

    public function scopeWithReviewsCount($query)
    {
        return $query->withCount('reviews');
    }

    public function scopeWithBookingsCount($query)
    {
        return $query->withCount('bookings');
    }

    public function scopePopular($query)
    {
        return $query->withCount('bookings')
            ->orderBy('bookings_count', 'desc');
    }

    public function scopeHighlyRated($query, $minRating = 4)
    {
        return $query->whereHas('reviews', function ($q) use ($minRating) {
            $q->selectRaw('AVG(rating)')
                ->groupBy('service_id')
                ->havingRaw('AVG(rating) >= ?', [$minRating]);
        });
    }

    public function scopeWithFavoritesCount($query)
    {
        return $query->withCount('favorites');
    }
}
