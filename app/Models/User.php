<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ================= ROLE CONSTANTS =================
    const ROLE_SUPER_ADMIN   = 'super_admin';
    const ROLE_SCHOOL_ADMIN  = 'school_admin';
    const ROLE_TEACHER       = 'teacher';
    const ROLE_STUDENT       = 'student';
    const ROLE_PARENT        = 'parent';
    const ROLE_ACCOUNTANT    = 'accountant';
    const ROLE_DRIVER        = 'driver';
    const ROLE_HOSTEL        = 'hostel_super';

    // ================= FILLABLE =================
    protected $fillable = [
        'name','email','password','role','school_id',

        // student fields
        'student_id','mobile',
        'father_name','mother_name',
        'gender','dob','class_id','section_id','roll',

        // transport
        'route_id','driver_id','parent_id',

        // address
        'address1','address2','state','district','block','city','pin',

        // misc
        'photo','is_active',
        'teacher_code','account_code','hostel_super_code','transport_code',
        'status'
    ];

    // ================= HIDDEN =================
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ================= CAST =================
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ================= RELATIONS =================

    // 🏫 School
    public function school()
    {
        return $this->belongsTo(\App\Models\School::class);
    }

    // 🎓 Class (RENAMED - NO CONFLICT)
    public function studentClass()
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'class_id');
    }

    // 🧾 Section (RENAMED)
    public function studentSection()
    {
        return $this->belongsTo(\App\Models\Section::class, 'section_id');
    }

    // 👨‍👩‍👧 Parent
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // 👶 Children (for parent)
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    // 🚐 Transport Route
    public function route()
    {
        return $this->belongsTo(\App\Models\TransportRoute::class, 'route_id');
    }

    // 🚗 Driver
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    // 📚 Subjects (Teacher)
    public function subjects()
    {
        return $this->belongsToMany(
            \App\Models\Subject::class,
            'subject_teacher',
            'teacher_id',
            'subject_id'
        );
    }

    // 📊 Results (Student)
    public function results()
    {
        return $this->hasMany(\App\Models\Result::class, 'student_id');
    }

    // 🔐 Login Logs
    public function logs()
    {
        return $this->hasMany(\App\Models\LoginLog::class);
    }

    // ================= HELPERS =================

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isSchoolAdmin()
    {
        return $this->role === self::ROLE_SCHOOL_ADMIN;
    }

    public function isTeacher()
    {
        return $this->role === self::ROLE_TEACHER;
    }

    public function isStudent()
    {
        return $this->role === self::ROLE_STUDENT;
    }

    public function isParent()
    {
        return $this->role === self::ROLE_PARENT;
    }
}