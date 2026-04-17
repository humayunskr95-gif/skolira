<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendanceExport implements FromCollection
{
    protected $classId, $sectionId;

    public function __construct($classId, $sectionId)
    {
        $this->classId = $classId;
        $this->sectionId = $sectionId;
    }

    public function collection()
    {
        return Attendance::with('student')
            ->where('class_id', $this->classId)
            ->where('section_id', $this->sectionId)
            ->get()
            ->map(function ($att) {
                return [
                    'Roll'   => $att->student->roll,
                    'Name'   => $att->student->name,
                    'Date'   => $att->date,
                    'Status' => $att->status,
                ];
            });
    }
}