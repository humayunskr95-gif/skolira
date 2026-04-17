<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    /**
     * 🔐 Mass Assignable
     */
    protected $fillable = [
        'staff_id',
        'school_id',
        'reason',
        'from_date',
        'to_date',
        'status',
    ];

    /**
     * 📅 Date Casting
     */
    protected $casts = [
        'from_date' => 'date',
        'to_date'   => 'date',
    ];

    /**
     * 👨‍🏫 Staff (Teacher/User)
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * 🏫 School
     */
    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    /**
     * 🔎 Scope: School Wise
     */
    public function scopeSchool($query)
    {
        return $query->where('school_id', auth()->user()->school_id);
    }

    /**
     * 🔎 Scope: Status Filter
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 🎯 Helper: Total Days
     */
    public function getTotalDaysAttribute()
    {
        return $this->from_date->diffInDays($this->to_date) + 1;
    }

    /**
     * 🎨 Helper: Status Color (UI use)
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'approved' => 'green',
            'rejected' => 'red',
            default    => 'yellow',
        };
    }

    /**
     * 🔐 Boot (Auto set school_id)
     */
    protected static function booted()
    {
        static::creating(function ($leave) {
            if (auth()->check()) {
                $leave->school_id = auth()->user()->school_id;
            }
        });
    }
}