<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToSchool; // 👈 IMPORT

class Student extends Model
{
    use BelongsToSchool; // 👈 USE HERE

    protected $fillable = [
        'name',
        'class',
        'school_id',
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}