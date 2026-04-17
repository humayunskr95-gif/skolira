<?php

namespace App\Exports;

use App\Models\TransportRoute;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RouteExport implements FromCollection, WithHeadings
{
    /**
     * 📊 Data Export
     */
    public function collection()
    {
        return TransportRoute::where('school_id', Auth::user()->school_id)
            ->select(
                'name',
                'start_point',
                'end_point',
                'created_at'
            )
            ->get();
    }

    /**
     * 📌 Excel Heading
     */
    public function headings(): array
    {
        return [
            'Route Name',
            'Start Point',
            'End Point',
            'Created Date'
        ];
    }
}