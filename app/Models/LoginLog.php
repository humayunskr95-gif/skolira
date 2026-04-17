<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip',
        'device',
        'browser',
        'platform',
    ];

    /**
     * 🔗 Relation: Log belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}