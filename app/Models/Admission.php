<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        'email',
        'mobile',
        'class',
        'address',
        'photo',
        'status'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
