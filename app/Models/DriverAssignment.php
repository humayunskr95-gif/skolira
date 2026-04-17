<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\TransportRoute;

class DriverAssignment extends Model
{
    protected $fillable = [
        'driver_id',
        'vehicle_id',
        'route_id',
    ];

    /**
     * 👨‍✈️ Driver (User)
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * 🚐 Vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /**
     * 🛣 Route
     */
    public function route()
    {
        return $this->belongsTo(TransportRoute::class, 'route_id');
    }

    /**
     * 🏫 School (FIXED RELATION)
     */
    public function school()
    {
        return $this->driver()->withDefault();
    }
}