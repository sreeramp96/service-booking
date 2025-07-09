<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
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
}
