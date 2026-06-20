<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Batch Records: ') . $batchName }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8 px-0 sm:px-4 lg:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 sm:mb-10 pb-4 sm:pb-6 border-b border-gray-100 gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-yellow-600 rounded-lg shadow-yellow-200 shadow-lg flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900 lg:text-3xl truncate">
                            {{ $batchName }}
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">
                            Viewing all archived records in this batch.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                <form action="{{ route('payments.archived.show', $batchName) }}" method="GET" class="relative flex items-center group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-yellow-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search records..." 
                        autocomplete="off"
                        class="block w-full sm:w-64 pl-10 pr-12 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-500 focus:border-transparent bg-gray-50/50 transition-all">
                    
                    @if(request('search'))
                        <a href="{{ route('payments.archived.show', $batchName) }}" class="absolute right-3 text-xs font-bold text-red-500 hover:text-red-700">
                            CLEAR
                        </a>
                    @endif
                </form>

                <a href="{{ route('payments.archived') }}" 
                class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 bg-gray-100 text-gray-700 text-xs sm:text-sm font-bold rounded-xl border border-gray-300 hover:bg-gray-200 hover:-translate-y-0.5 transition-all active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Batches
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md shadow-sm flex items-center">
                <svg class="h-5 w-5 text-green-400 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Mobile Card View --}}
        <div class="block sm:hidden space-y-3">
            @forelse($payments as $payment)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $payment->student_name }}</h4>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                {{ $payment->course }} - {{ $payment->year_level ?? '1st Year' }}
                            </span>
                        </div>
                        <span class="text-lg font-bold text-green-600 ml-2 flex-shrink-0">₱{{ number_format($payment->amount, 2) }}</span>
                    </div>
                    <div class="text-xs text-gray-500 space-y-1">
                        <p>📅 {{ \Carbon\Carbon::parse($payment->date)->format('M d, Y') }}</p>
                        <p>📝 {{ $payment->description }}</p>
                        <p>👤 
                            @if($payment->recorded_by_name)
                                {{ $payment->recorded_by_name }} <span class="text-blue-500 font-bold">(File)</span>
                            @else
                                {{ $payment->recorder->name ?? 'Unknown' }}
                            @endif
                        </p>
                    </div>
                    @if(auth()->user()->role === 'admin')
                    <div class="mt-3 pt-3 border-t border-gray-100 flex justify-end">
                        <form action="{{ route('payments.restore', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Restore this individual record?')">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900 transition flex items-center gap-1 font-semibold text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                Restore
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No records found</h3>
                    <p class="mt-1 text-sm text-gray-500">There are no records in this batch.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden sm:block bg-white shadow-md rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Course</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Recorded By</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $payment->student_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $payment->course }} - {{ $payment->year_level ?? '1st Year' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                    ₱{{ number_format($payment->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($payment->date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-7 w-7 bg-gray-100 rounded-full flex items-center justify-center mr-2">
                                            <span class="text-xs font-medium text-gray-600">
                                                {{ strtoupper(substr($payment->recorded_by_name ?? $payment->recorder->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span>
                                            @if($payment->recorded_by_name)
                                                {{ $payment->recorded_by_name }} 
                                                <span class="text-[10px] text-blue-500 font-bold ml-1">(File)</span>
                                            @else
                                                {{ $payment->recorder->name ?? 'Unknown' }}
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium">
                                    <div class="flex items-center justify-center space-x-4">
                                        @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('payments.restore', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Restore this individual record?')">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 transition flex items-center gap-1 font-semibold" title="Restore">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                                Restore
                                            </button>
                                        </form>
                                        @else
                                        <span class="text-gray-400 text-xs">Admin only</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No records found</h3>
                                    <p class="mt-1 text-sm text-gray-500">There are no records in this batch.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row items-center justify-between bg-white p-3 sm:p-4 border border-gray-200 rounded-lg shadow-sm gap-3">
            <div class="text-xs sm:text-sm text-gray-700">
                Showing <span class="font-medium">{{ $payments->firstItem() ?? 0 }}</span> 
                to <span class="font-medium">{{ $payments->lastItem() ?? 0 }}</span> 
                of <span class="font-medium">{{ $payments->total() }}</span> records
            </div>
            <div class="pagination-white">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
