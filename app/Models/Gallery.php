<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'school_id',
        'image',
        'title'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
