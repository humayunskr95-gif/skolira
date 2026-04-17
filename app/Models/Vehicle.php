<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * 🔐 Mass Assignable Fields
     */
    protected $fillable = [
        'vehicle_no',
        'vehicle_type',
        'capacity',
        'school_id',
    ];

    /**
     * 🏫 Belongs to School (optional future)
     */
    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    /**
     * 🔗 Driver Assignments
     */
    public function assignments()
    {
        return $this->hasMany(DriverAssignment::class);
    }

    /**
     * 🚐 Vehicle current driver (optional shortcut)
     */
    public function driver()
    {
        return $this->hasOneThrough(
            User::class,
            DriverAssignment::class,
            'vehicle_id', // FK in assignments
            'id',         // FK in users
            'id',         // local vehicle id
            'driver_id'   // FK in assignments
        );
    }
}