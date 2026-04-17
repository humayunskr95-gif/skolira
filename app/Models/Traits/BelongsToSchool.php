<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait BelongsToSchool
{
    protected static function bootBelongsToSchool()
    {
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->school_id) {
                $model->school_id = Auth::user()->school_id;
            }
        });

        static::addGlobalScope('school', function ($query) {
            if (Auth::check() && Auth::user()->school_id) {
                $query->where('school_id', Auth::user()->school_id);
            }
        });
    }
}