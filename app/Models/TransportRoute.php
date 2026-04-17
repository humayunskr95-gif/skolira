<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    protected $table = 'transport_routes'; // ✅ FIXED

    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'school_id',
    ];

    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    public function assignments()
    {
        return $this->hasMany(DriverAssignment::class, 'route_id');
    }

    public function vehicles()
    {
        return $this->hasManyThrough(
            Vehicle::class,
            DriverAssignment::class,
            'route_id',
            'id',
            'id',
            'vehicle_id'
        );
    }

    public function drivers()
    {
        return $this->hasManyThrough(
            User::class,
            DriverAssignment::class,
            'route_id',
            'id',
            'id',
            'driver_id'
        );
    }
}