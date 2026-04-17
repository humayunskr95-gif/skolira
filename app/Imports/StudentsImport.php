<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $school = Auth::user()->school;

        // skip empty row
        if (!$row['name'] || !$row['mobile']) {
            return null;
        }

        // skip duplicate
        if (User::where('mobile', $row['mobile'])->exists()) {
            return null;
        }

        $regNo = 'SKOLIRAREG' . rand(1000,9999);

        // 👨‍🎓 Student
        $student = User::create([
            'name'        => $row['name'],
            'email'       => $row['mobile'].'@student.com',
            'password'    => Hash::make('123456'),
            'role'        => 'student',
            'school_id'   => $school->id,

            'student_id'  => $regNo,
            'mobile'      => $row['mobile'],

            'father_name' => $row['father_name'] ?? null,
            'mother_name' => $row['mother_name'] ?? null,

            'class'       => $row['class'] ?? null,
            'section'     => $row['section'] ?? null,

            'address1'    => $row['address1'] ?? null,
            'city'        => $row['city'] ?? null,
            'district'    => $row['district'] ?? null,

            'is_active'   => 1
        ]);

        // 👨‍👩‍👧 Parent
        User::create([
            'name'      => $row['father_name'] ?? 'Parent',
            'email'     => $row['mobile'].'@parent.com',
            'password'  => Hash::make('12345'),
            'role'      => 'parent',
            'school_id' => $school->id,
            'mobile'    => $row['mobile'],
            'is_active' => 1
        ]);

        return $student;
    }
}