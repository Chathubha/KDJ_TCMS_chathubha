<?php

namespace App\Services;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FeeService
{
    public function getAllFees(array $filters = []): LengthAwarePaginator
    {
        $query = Fee::with(['classroom', 'payments']);

        if (!empty($filters['classroom_id'])) {
            $query->where('classroom_id', $filters['classroom_id']);
        }
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->orderBy('due_date', 'desc')->paginate(15);
    }

    public function getFeeById(int $id): Fee
    {
        return Fee::with(['classroom', 'payments.student'])->findOrFail($id);
    }

    public function createFee(array $data): Fee
    {
        return Fee::create($data);
    }

    public function updateFee(Fee $fee, array $data): Fee
    {
        $fee->update($data);
        return $fee;
    }

    public function deleteFee(Fee $fee): bool
    {
        return $fee->delete();
    }

    public function getStudentsForPayment(int $feeId): array
    {
        $fee = Fee::with('classroom')->findOrFail($feeId);
        $students = Student::whereHas('classrooms', fn($q) => $q->where('classrooms.id', $fee->classroom_id))
            ->with(['payments' => fn($q) => $q->where('fee_id', $feeId)])
            ->orderBy('first_name')
            ->get();

        return ['fee' => $fee, 'students' => $students];
    }

    public function storePayment(int $feeId, array $data, int $receivedBy): Payment
    {
        return Payment::create(array_merge($data, [
            'fee_id' => $feeId,
            'received_by' => $receivedBy,
        ]));
    }

    public function deletePayment(Payment $payment): bool
    {
        return $payment->delete();
    }

    public function getStudentFees(int $studentId): array
    {
        $student = Student::with(['classrooms', 'payments.fee'])->findOrFail($studentId);
        $classroom = $student->classrooms->first();

        $fees = [];
        if ($classroom) {
            $fees = Fee::where('classroom_id', $classroom->id)
                ->with(['payments' => fn($q) => $q->where('student_id', $studentId)])
                ->orderBy('due_date', 'desc')
                ->get()
                ->map(function ($fee) {
                    $paid = $fee->payments->sum('amount_paid');
                    return [
                        'fee' => $fee,
                        'paid' => $paid,
                        'balance' => $fee->amount - $paid,
                        'is_paid' => $paid >= $fee->amount,
                    ];
                });
        }

        return ['student' => $student, 'fees' => $fees, 'totalDue' => $fees->sum('balance'), 'totalPaid' => $fees->sum('paid')];
    }

    public function getStats(): array
    {
        return [
            'totalFees' => Fee::count(),
            'totalCollected' => (float) Payment::sum('amount_paid'),
            'totalPending' => (float) Fee::sum('amount') - (float) Payment::sum('amount_paid'),
            'recentPayments' => Payment::with(['student', 'fee.classroom'])->latest()->take(10)->get(),
        ];
    }
}
