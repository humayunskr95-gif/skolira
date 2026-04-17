<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HostelSuperExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::where('role','hostel_super')
            ->select(
                'hostel_super_code',
                'name',
                'father_name',
                'mobile',
                'email',
                'city',
                'district',
                'state'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Father Name',
            'Mobile',
            'Email',
            'City',
            'District',
            'State'
        ];
    }
}