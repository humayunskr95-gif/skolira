<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table = 'homeworks'; // 👈 MUST ADD

    protected $fillable = [
        'teacher_id','subject_id','class_id','section_id',
        'title','description','due_date'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }
}