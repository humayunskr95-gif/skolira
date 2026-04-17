<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = ['name'];

    // 🔗 Relation
    public function sections()
    {
        return $this->hasMany(Section::class, 'school_class_id');
    }
}