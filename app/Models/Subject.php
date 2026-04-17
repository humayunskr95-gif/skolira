<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SchoolClass;
use App\Models\User;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'class_id'
    ];

    // 🏫 Class relation
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    // 👨‍🏫 Teachers (Many-to-Many)
    public function teachers()
    {
        return $this->belongsToMany(
            User::class,
            'subject_teacher',
            'subject_id',
            'teacher_id'
        );
    }
}