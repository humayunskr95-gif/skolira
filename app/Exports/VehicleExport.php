<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VehicleExport implements FromCollection, WithHeadings
{
    /**
     * 📊 Data Export
     */
    public function collection()
    {
        return Vehicle::where('school_id', Auth::user()->school_id)
            ->select(
                'vehicle_no',
                'vehicle_type',
                'capacity',
                'created_at'
            )
            ->get();
    }

    /**
     * 📌 Excel Header
     */
    public function headings(): array
    {
        return [
            'Vehicle No',
            'Vehicle Type',
            'Capacity',
            'Created Date'
        ];
    }
}