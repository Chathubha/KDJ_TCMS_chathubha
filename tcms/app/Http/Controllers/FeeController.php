<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Payment;
use App\Models\Classroom;
use App\Services\FeeService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function __construct(private FeeService $feeService) {}

    public function index(Request $request)
    {
        $fees = $this->feeService->getAllFees($request->only(['classroom_id', 'type']));
        $classrooms = Classroom::orderBy('name')->get();
        $types = ['tuition', 'exam', 'lab', 'transport', 'library', 'other'];

        return view('fees.index', compact('fees', 'classrooms', 'types'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('name')->get();
        $types = ['tuition', 'exam', 'lab', 'transport', 'library', 'other'];
        return view('fees.create', compact('classrooms', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year' => 'required|string|max:10',
            'type' => 'required|in:tuition,exam,lab,transport,library,other',
            'due_date' => 'nullable|date',
        ]);

        $this->feeService->createFee($validated);

        return redirect()->route('fees.index')->with('success', 'Fee created successfully.');
    }

    public function show($id)
    {
        $data = $this->feeService->getStudentsForPayment($id);
        return view('fees.show', $data);
    }

    public function edit($id)
    {
        $fee = $this->feeService->getFeeById($id);
        $classrooms = Classroom::orderBy('name')->get();
        $types = ['tuition', 'exam', 'lab', 'transport', 'library', 'other'];
        return view('fees.edit', compact('fee', 'classrooms', 'types'));
    }

    public function update(Request $request, $id)
    {
        $fee = $this->feeService->getFeeById($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'classroom_id' => 'required|exists:classrooms,id',
            'academic_year' => 'required|string|max:10',
            'type' => 'required|in:tuition,exam,lab,transport,library,other',
            'due_date' => 'nullable|date',
        ]);

        $this->feeService->updateFee($fee, $validated);

        return redirect()->route('fees.index')->with('success', 'Fee updated successfully.');
    }

    public function destroy($id)
    {
        $fee = $this->feeService->getFeeById($id);
        $this->feeService->deleteFee($fee);
        return redirect()->route('fees.index')->with('success', 'Fee deleted successfully.');
    }

    public function storePayment(Request $request, $id)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,card,online,other',
            'receipt_number' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:255',
        ]);

        $this->feeService->storePayment($id, $validated, auth()->id());

        return redirect()->route('fees.show', $id)->with('success', 'Payment recorded successfully.');
    }

    public function destroyPayment($feeId, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $this->feeService->deletePayment($payment);
        return redirect()->route('fees.show', $feeId)->with('success', 'Payment deleted successfully.');
    }

    public function studentFees($studentId)
    {
        $data = $this->feeService->getStudentFees($studentId);
        return view('fees.student-fees', $data);
    }
}
