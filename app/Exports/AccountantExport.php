<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountantExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::where('role','accountant')
            ->select(
                'account_code',
                'name',
                'father_name',
                'mobile',
                'email',
                'city',
                'district',
                'state',
                'created_at'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Account Code',
            'Name',
            'Father Name',
            'Mobile',
            'Email',
            'City',
            'District',
            'State',
            'Created At'
        ];
    }
}