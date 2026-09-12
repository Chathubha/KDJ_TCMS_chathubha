<?php

namespace Database\Seeders;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    public function run(): void
    {
        $classrooms = Classroom::all();
        $adminId = User::where('role', 'admin')->first()->id;
        $types = ['tuition', 'exam', 'lab', 'transport'];

        foreach ($classrooms as $class) {
            $feeTypes = collect($types)->random(2);
            foreach ($feeTypes as $type) {
                $fee = Fee::create([
                    'name' => ucfirst($type) . ' Fee - ' . $class->name . '-' . $class->section,
                    'description' => ucfirst($type) . ' fee for ' . $class->academic_year,
                    'amount' => $type === 'tuition' ? 5000 : ($type === 'exam' ? 1500 : ($type === 'lab' ? 1000 : 2000)),
                    'classroom_id' => $class->id,
                    'academic_year' => $class->academic_year,
                    'type' => $type,
                    'due_date' => now()->addDays(rand(10, 60)),
                ]);

                // Random students pay
                $students = $class->students->random(min(3, $class->students->count()));
                foreach ($students as $student) {
                    $paidAmount = $type === 'tuition' ? rand(2000, 5000) : rand(500, $fee->amount);
                    Payment::create([
                        'fee_id' => $fee->id,
                        'student_id' => $student->id,
                        'amount_paid' => min($paidAmount, $fee->amount),
                        'payment_date' => now()->subDays(rand(1, 30)),
                        'payment_method' => collect(['cash', 'bank_transfer', 'online'])->random(),
                        'receipt_number' => 'RCP-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                        'received_by' => $adminId,
                    ]);
                }
            }
        }
    }
}
