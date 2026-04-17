<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeachersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name'        => $row['name'],
            'father_name' => $row['father_name'] ?? null,
            'email'       => $row['email'],
            'mobile'      => $row['mobile'],

            // 🔥 AUTO TEACHER CODE
            'teacher_code' => 'SKTEA' . rand(10,99),

            // 🔐 DEFAULT PASSWORD
            'password'    => Hash::make('123456'),

            'role'        => 'teacher',
            'school_id'   => auth()->user()->school_id,

            'is_active'   => 1
        ]);
    }
}