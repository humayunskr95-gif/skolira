<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    /**
     * Mass Assignable Fields
     */
    protected $fillable = [
    'school_id',
    'plan_id',
    'amount', // 🔥 MUST ADD
    'start_date',
    'end_date',
    'status'
];

    /**
     * Type Casting
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /**
     * Relationships
     */

    // 🔗 Subscription belongs to Plan
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    // 🔗 Subscription belongs to School
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * 🔥 Helper Methods (Very Useful)
     */

    // ✅ Check active
    public function isActive()
    {
        return $this->status === 'active' && $this->end_date >= now();
    }

    // ❌ Check expired
    public function isExpired()
    {
        return $this->end_date < now();
    }

    // ⏳ Days left
    public function daysLeft()
    {
        return now()->diffInDays($this->end_date, false);
    }

    // 🔥 Expire automatically (optional use)
    public function checkAndExpire()
    {
        if ($this->isExpired()) {
            $this->update(['status' => 'expired']);
        }
    }

    /**
     * 🔥 Accessors (Pro UI)
     */

    // 📅 Formatted Start Date
    public function getStartAttribute()
    {
        return $this->start_date?->format('d M Y');
    }

    // 📅 Formatted End Date
    public function getEndAttribute()
    {
        return $this->end_date?->format('d M Y');
    }

    // 🎨 Status Badge
    public function getStatusBadgeAttribute()
    {
        return $this->isActive()
            ? '<span style="color:green;">Active</span>'
            : '<span style="color:red;">Expired</span>';
    }
}