<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Section;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'student_id',
        'school_id',
        'class_id',
        'section_id',
        'date',
        'status'
    ];

    protected $casts = [
        'date' => 'date', // 📅 auto Carbon
    ];

    // ================= RELATIONS =================

    // 👨‍🎓 Student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // 🏫 Class
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // 📚 Section
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    // ================= SCOPES =================

    // 📅 Today Attendance
    public function scopeToday($query)
    {
        return $query->whereDate('date', now());
    }

    // 🏫 School filter
    public function scopeSchool($query, $schoolId)
    {
        return $query->where('school_id', $schoolId);
    }

    // 🎯 Class + Section filter
    public function scopeClassSection($query, $classId, $sectionId)
    {
        return $query->where('class_id', $classId)
                     ->where('section_id', $sectionId);
    }
}