<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    /**
     * 🔐 Mass Assignable
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'school_id',
        'date',
        'status',
    ];

    /**
     * 📅 Casts
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * 👨‍🎓 Student Relation
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * 🏫 Class Relation
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * 🏫 Scope: Current School
     */
    public function scopeSchool($query)
    {
        return $query->where('school_id', auth()->user()->school_id);
    }

    /**
     * 📅 Scope: Filter by Date
     */
    public function scopeDate($query, $date)
    {
        if ($date) {
            return $query->whereDate('date', $date);
        }
        return $query;
    }

    /**
     * 📊 Scope: Status Filter
     */
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }
}