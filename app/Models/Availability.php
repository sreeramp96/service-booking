<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Availability extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'date',
        'start_time',
        'end_time',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
