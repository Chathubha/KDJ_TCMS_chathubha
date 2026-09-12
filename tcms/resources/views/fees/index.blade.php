<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Fees & Payments</h2>
                <p class="text-sm text-gray-500 mt-1">Manage fee items and track student payments</p>
            </div>
            <a href="{{ route('fees.create') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">+ Add Fee</a>
        </div>
    </x-slot>

    @php
        $totalFees = \App\Models\Fee::count();
        $totalCollected = (float) \App\Models\Payment::sum('amount_paid');
        $totalPending = (float) \App\Models\Fee::sum('amount') - $totalCollected;
    @endphp

    <div class="space-y-6">
        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm font-medium text-gray-500">Total Fee Items</p>
                <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalFees }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm font-medium text-gray-500">Total Collected</p>
                <p class="text-3xl font-extrabold text-emerald-600 mt-1">Rs. {{ number_format($totalCollected, 2) }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <p class="text-sm font-medium text-gray-500">Total Pending</p>
                <p class="text-3xl font-extrabold text-red-600 mt-1">Rs. {{ number_format($totalPending, 2) }}</p>
            </div>
        </div>

        {{-- Filters --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <form method="GET" class="flex flex-wrap gap-3 items-center">
                <select name="classroom_id" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                    <option value="">All Classes</option>
                    @foreach($classrooms as $class)
                        <option value="{{ $class->id }}" {{ request('classroom_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}-{{ $class->section }}</option>
                    @endforeach
                </select>
                <select name="type" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">Filter</button>
            </form>
        </div>

        {{-- Fees Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Fee Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($fees as $fee)
                            @php
                                $paid = $fee->payments->sum('amount_paid');
                                $isPaid = $paid >= $fee->amount;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-gray-900">{{ $fee->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $fee->academic_year }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 capitalize">{{ $fee->type }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $fee->classroom->name ?? '-' }}-{{ $fee->classroom->section ?? '' }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">Rs. {{ number_format($fee->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $fee->due_date?->format('M d, Y') ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($isPaid)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">Paid</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('fees.show', $fee) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">View</a>
                                    <a href="{{ route('fees.edit', $fee) }}" class="text-gray-600 hover:text-gray-900 font-semibold">Edit</a>
                                    <form method="POST" action="{{ route('fees.destroy', $fee) }}" class="inline" onsubmit="return confirm('Delete this fee?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 font-semibold">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-4xl mb-3">💰</div>
                                    <p class="text-gray-500 font-medium">No fee items found</p>
                                    <a href="{{ route('fees.create') }}" class="inline-block mt-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">+ Create one</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">{{ $fees->withQueryString()->links() }}</div>
        </div>
    </div>
</x-app-layout>
