<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'school_class_id'
    ];

    // 🔗 Relation with Class
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'school_class_id');
    }
}