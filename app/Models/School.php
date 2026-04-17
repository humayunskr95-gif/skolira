<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
    'name',
    'code', // ✅ ADD THIS
    'owner_name',
    'address1',
    'address2',
    'city',
    'district',
    'state',
    'pin',
    'logo',
    'is_active',
    'student_limit',
    'slug', // ✅ MUST ADD
    'teacher_limit'
];

    // 👥 Relationship
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function notices()
{
    return $this->hasMany(\App\Models\Notice::class);
}
   public function galleries()
{
    return $this->hasMany(\App\Models\Gallery::class);
}
    public function admissions()
{
    return $this->hasMany(\App\Models\Admission::class);
}
  public function subscriptions()
{
    return $this->hasMany(\App\Models\Subscription::class);
}

public function subscription()
{
    return $this->hasOne(\App\Models\Subscription::class)
        ->where('status', 'active')
        ->latestOfMany();
}
}