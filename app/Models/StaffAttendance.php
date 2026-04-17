<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    /**
     * 🔐 Mass Assignable
     */
    protected $fillable = [
        'staff_id',
        'school_id',
        'date',
        'status',
        'check_in',
        'check_out',
    ];

    /**
     * 📅 Casting
     */
    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i',
        'check_out' => 'datetime:H:i',
    ];

    /**
     * 👨‍🏫 Staff (User)
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
     * 🔎 Scope: Date Filter
     */
    public function scopeDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * 🔎 Scope: Status Filter
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 🔎 Scope: Staff Filter
     */
    public function scopeStaff($query, $staff_id)
    {
        return $query->where('staff_id', $staff_id);
    }

    /**
     * 🎯 Helper: Status Color (UI)
     */
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'present' => 'green',
            'late'    => 'yellow',
            'absent'  => 'red',
            default   => 'gray',
        };
    }

    /**
     * 🎯 Helper: Status Label
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * ⏱ Helper: Working Hours
     */
    public function getWorkingHoursAttribute()
    {
        if ($this->check_in && $this->check_out) {
            return $this->check_in->diffInHours($this->check_out) . ' hrs';
        }
        return '-';
    }

    /**
     * 🔐 Auto set school_id
     */
    protected static function booted()
    {
        static::creating(function ($attendance) {
            if (auth()->check()) {
                $attendance->school_id = auth()->user()->school_id;
            }
        });
    }
}