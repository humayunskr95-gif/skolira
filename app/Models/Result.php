<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Subject;

class Result extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'marks',
        'grade'
    ];

    // 🔒 Type casting (important)
    protected $casts = [
        'marks' => 'integer',
    ];

    /**
     * 👨‍🎓 Student Relation
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * 📚 Subject Relation
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * 🎯 Auto Grade (optional helper)
     */
    public function getGradeAttribute($value)
    {
        if ($value) return $value;

        return match(true) {
            $this->marks >= 90 => 'A+',
            $this->marks >= 80 => 'A',
            $this->marks >= 70 => 'B',
            $this->marks >= 60 => 'C',
            default => 'F',
        };
    }
}