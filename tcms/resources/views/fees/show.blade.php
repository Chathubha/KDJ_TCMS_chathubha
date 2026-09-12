<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $fee->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $fee->classroom->name ?? '' }}-{{ $fee->classroom->section ?? '' }} · {{ ucfirst($fee->type) }} · {{ $fee->academic_year }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('fees.edit', $fee) }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl transition text-sm">Edit</a>
                <a href="{{ route('fees.index') }}" class="bg-white border-2 border-gray-200 text-gray-700 hover:bg-gray-50 font-semibold py-2 px-4 rounded-xl transition text-sm">← Back</a>
            </div>
        </div>
    </x-slot>

    @php
        $totalPaid = $fee->payments->sum('amount_paid');
        $balance = $fee->amount - $totalPaid;
        $paidPct = $fee->amount > 0 ? round($totalPaid / $fee->amount * 100, 1) : 0;
    @endphp

    <div class="space-y-6">
        {{-- Fee Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Fee Amount</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1">Rs. {{ number_format($fee->amount, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Collected</p>
                <p class="text-2xl font-extrabold text-emerald-600 mt-1">Rs. {{ number_format($totalPaid, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Balance</p>
                <p class="text-2xl font-extrabold {{ $balance > 0 ? 'text-red-600' : 'text-emerald-600' }} mt-1">Rs. {{ number_format($balance, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Due Date</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $fee->due_date?->format('M d') ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Payment Progress --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Collection Progress</span>
                <span class="text-sm font-bold text-indigo-600">{{ $paidPct }}%</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-3">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-3 rounded-full transition-all" style="width: {{ $paidPct }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Record Payment --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Record Payment</h3>
                <form method="POST" action="{{ route('fees.payments.store', $fee) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Student *</label>
                        <select name="student_id" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none text-sm" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->full_name }}</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Amount (Rs.) *</label>
                        <input type="number" name="amount_paid" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none text-sm" min="0" step="0.01" required>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date *</label>
                            <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none text-sm" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Method *</label>
                            <select name="payment_method" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none text-sm" required>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="card">Card</option>
                                <option value="online">Online</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Receipt #</label>
                        <input type="text" name="receipt_number" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none text-sm" placeholder="Optional">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks</label>
                        <input type="text" name="remarks" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none text-sm" placeholder="Optional">
                    </div>
                    <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-xl transition shadow-sm">Record Payment</button>
                </form>
            </div>

            {{-- Payment History --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-5">Payment History</h3>
                @if($fee->payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Student</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Amount</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Method</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Receipt</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($fee->payments as $payment)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $payment->student->full_name ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm font-bold text-emerald-600 text-right">Rs. {{ number_format($payment->amount_paid, 2) }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500 capitalize">{{ $payment->payment_method }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-500">{{ $payment->receipt_number ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <form method="POST" action="{{ route('fees.payments.destroy', [$fee, $payment]) }}" class="inline" onsubmit="return confirm('Delete this payment?')">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:text-red-700 text-xs font-semibold">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10 bg-gray-50 rounded-xl">
                        <div class="text-4xl mb-3">💳</div>
                        <p class="text-gray-500 font-medium">No payments recorded yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
