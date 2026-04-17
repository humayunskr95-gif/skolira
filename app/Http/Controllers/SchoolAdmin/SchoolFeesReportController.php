<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Fee;
use App\Models\SchoolClass;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SchoolFeesReportController extends Controller
{
    public function report(Request $request)
    {
        return view('school_admin.fees.report_v2', $this->buildReportData($request));
    }

    public function exportPdf(Request $request)
    {
        $report = $this->buildReportData($request);

        $className = $report['selectedClass']?->name ?? 'all-classes';
        $exportType = $report['exportType'];
        $fileName = 'fees-' . $exportType . '-' . str($className)->slug() . '-' . now()->format('Ymd-His') . '.pdf';

        return Pdf::loadView('school_admin.fees.report_pdf', $report)
            ->setPaper('a4', 'portrait')
            ->download($fileName);
    }

    private function buildReportData(Request $request): array
    {
        $schoolId = auth()->user()->school_id;
        $from = $request->filled('from')
            ? now()->parse($request->from)->startOfDay()
            : now()->startOfMonth()->startOfDay();
        $to = $request->filled('to')
            ? now()->parse($request->to)->endOfDay()
            : now()->endOfDay();
        $classId = $request->integer('class_id');
        $exportType = $request->get('export_type', 'final');
        if (! in_array($exportType, ['paid', 'due', 'final'], true)) {
            $exportType = 'final';
        }

        $classes = SchoolClass::orderBy('name')->get();
        $students = User::where('school_id', $schoolId)
            ->where('role', 'student')
            ->get();
        $studentsById = $students->keyBy(fn ($student) => (string) $student->id);
        $studentsByCode = $students
            ->filter(fn ($student) => ! empty($student->student_id))
            ->keyBy(fn ($student) => (string) $student->student_id);

        $fees = Fee::with(['student', 'class'])
            ->where('school_id', $schoolId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->when($classId, fn ($query) => $query->where('class_id', $classId))
            ->orderBy('class_id')
            ->orderBy('date')
            ->get()
            ->map(function ($fee) use ($studentsByCode, $studentsById) {
                $amount = (float) ($fee->amount ?? 0);
                $paidAmount = $fee->paid_amount !== null
                    ? (float) $fee->paid_amount
                    : (($fee->status ?? null) === 'paid' ? $amount : 0);

                $paidAmount = min($paidAmount, $amount);
                $dueAmount = max($amount - $paidAmount, 0);

                if ($dueAmount == 0 && $amount > 0) {
                    $derivedStatus = 'paid';
                } elseif ($paidAmount > 0) {
                    $derivedStatus = 'partial';
                } else {
                    $derivedStatus = 'due';
                }

                $fee->calculated_amount = $amount;
                $fee->calculated_paid_amount = $paidAmount;
                $fee->calculated_due_amount = $dueAmount;
                $fee->calculated_status = $fee->status ?? $derivedStatus;
                $resolvedStudent = $fee->student
                    ?? $studentsById->get((string) $fee->student_id)
                    ?? $studentsByCode->get((string) $fee->student_id);
                $fee->resolved_student_name = $resolvedStudent?->name ?? 'Unknown Student';

                return $fee;
            });

        $expenses = Expense::query()
            ->where('school_id', $schoolId)
            ->whereBetween('date', [$from->toDateString(), $to->toDateString()])
            ->orderByDesc('date')
            ->get();

        if ($exportType === 'paid') {
            $fees = $fees->filter(fn ($fee) => $fee->calculated_paid_amount > 0)->values();
            $expenses = collect();
        } elseif ($exportType === 'due') {
            $fees = $fees->filter(fn ($fee) => $fee->calculated_due_amount > 0)->values();
            $expenses = collect();
        }

        $total = $fees->sum('calculated_amount');
        $paid = $fees->sum('calculated_paid_amount');
        $due = $fees->sum('calculated_due_amount');
        $expense = $expenses->sum('amount');
        $netBalance = $paid - $expense;

        $classWise = $fees
            ->groupBy(fn ($fee) => optional($fee->class)->name ?? ('Class ' . ($fee->class_id ?? 'N/A')))
            ->map(function ($group, $className) {
                return [
                    'class_name' => $className,
                    'students' => $group->count(),
                    'total' => $group->sum('calculated_amount'),
                    'paid' => $group->sum('calculated_paid_amount'),
                    'due' => $group->sum('calculated_due_amount'),
                ];
            })
            ->values();

        return [
            'classes' => $classes,
            'selectedClass' => $classId ? $classes->firstWhere('id', $classId) : null,
            'classId' => $classId,
            'fees' => $fees,
            'expenses' => $expenses,
            'classWise' => $classWise,
            'total' => $total,
            'paid' => $paid,
            'due' => $due,
            'expense' => $expense,
            'netBalance' => $netBalance,
            'exportType' => $exportType,
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
        ];
    }
}
