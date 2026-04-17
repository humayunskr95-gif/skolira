<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    /**
     * 🔐 Mass Assignable
     */
    protected $fillable = [
        'student_id',
        'class_id',
        'school_id',
        'amount',
        'payment_method',
        'transaction_id',
        'date',
    ];

    /**
     * 📅 Date Casting
     */
    protected $casts = [
        'date' => 'date',
    ];

    /**
     * 👨‍🎓 Student Relation (users table)
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * 🏫 Class Relation
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * 🏢 School Relation (Admin / School Owner)
     */
    public function school()
    {
        return $this->belongsTo(User::class, 'school_id');
    }

    /**
     * 🔎 Scope → Current School Filter
     */
    public function scopeSchool($query)
    {
        return $query->where('school_id', auth()->user()->school_id);
    }

    /**
     * 📅 Scope → Today
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', now());
    }

    /**
     * 📆 Scope → This Month
     */
    public function scopeMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                     ->whereYear('date', now()->year);
    }

    /**
     * 📅 Scope → This Year
     */
    public function scopeYear($query)
    {
        return $query->whereYear('date', now()->year);
    }

    /**
     * 💰 Accessor → Format Amount
     */
    public function getFormattedAmountAttribute()
    {
        return '₹ ' . number_format($this->amount, 2);
    }

    /**
     * 🔄 Helper → Payment Status (future use)
     */
    public function isPaid()
    {
        return $this->amount > 0;
    }
    public function getDueAttribute()
{
    return $this->amount - $this->paid_amount;
}
}