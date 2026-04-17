<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [

    'name','price','duration',

    'student_limit','teacher_limit','parent_limit',

    // academic
    'subjects','classes','sections',

    // study
    'attendance','results',

    // finance
    'fees','accountant',

    // hostel
    'hostel',

    // transport
    'driver','driver_assign','vehicles','routes',

    // staff
    'staff_attendance','leave',

    // report
    'reports',
];

    /**
     * Type Casting
     */
    protected $casts = [
        'price' => 'integer',
        'duration' => 'integer',
    ];

    /**
     * Relationships
     */

    // 🔗 One Plan → Many Subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Accessors (Optional - Pro Feature)
     */

    // 💰 Price with currency
    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price);
    }

    // ⏳ Duration in readable format
    public function getDurationLabelAttribute()
    {
        return $this->duration . ' Days';
    }
}