<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeachersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::where('role','teacher')
            ->select(
                'name',
                'father_name',
                'teacher_code',
                'mobile',
                'email',
                'is_active'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Father Name',
            'Teacher Code',
            'Mobile',
            'Email',
            'Status'
        ];
    }
}