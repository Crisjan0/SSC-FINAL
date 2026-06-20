<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div class="flex items-center gap-3">
                <a href="{{ route('collections.index') }}" class="text-gray-500 hover:text-green-600 transition-colors bg-gray-100 p-2 rounded-lg hover:bg-green-50 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight truncate">
                    {{ $course ?: 'Unknown Course' }} Collections
                </h2>
            </div>
            <div class="text-sm sm:text-lg font-bold text-green-600 bg-green-50 px-3 sm:px-4 py-1.5 rounded-full shadow-sm border border-green-100 text-center sm:text-right flex-shrink-0">
                Total: ₱{{ number_format($totalCollection, 2) }}
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-8 px-0 sm:px-4 lg:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 sm:mb-8 pb-4 sm:pb-6 border-b border-gray-100 gap-4">
            <div class="flex-1 min-w-0">
                <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900 lg:text-3xl">
                    Payments for {{ $course ?: 'Unknown Course' }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                    Showing all recorded payments for students enrolled in this course.
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                {{-- Year Level Filter --}}
                <form action="{{ route('collections.show', $course) }}" method="GET" class="flex items-center gap-2">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="year_level" onchange="this.form.submit()" 
                        class="block w-full sm:w-40 py-2.5 px-3 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50/50 transition-all cursor-pointer">
                        <option value="">All Year Levels</option>
                        <option value="1st Year" {{ request('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                        <option value="2nd Year" {{ request('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3rd Year" {{ request('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4th Year" {{ request('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                    </select>
                </form>

                {{-- Search --}}
                <form action="{{ route('collections.show', $course) }}" method="GET" class="relative flex items-center group">
                    @if(request('year_level'))
                        <input type="hidden" name="year_level" value="{{ request('year_level') }}">
                    @endif
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search records..." 
                        autocomplete="off"
                        class="block w-full sm:w-64 pl-10 pr-12 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent bg-gray-50/50 transition-all">
                    
                    @if(request('search') || request('year_level'))
                        <a href="{{ route('collections.show', $course) }}" class="absolute right-3 text-xs font-bold text-red-500 hover:text-red-700">
                            CLEAR
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Filtered Total Banner --}}
        @if(request('year_level'))
            <div class="mb-4 sm:mb-6 bg-blue-50 border border-blue-100 rounded-xl px-4 sm:px-5 py-3 flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs sm:text-sm text-blue-700">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    <span>Filtered by <strong>{{ request('year_level') }}</strong></span>
                </div>
                <div class="text-base sm:text-lg font-black text-blue-700">
                    ₱{{ number_format($filteredTotal, 2) }}
                </div>
            </div>
        @endif

        {{-- Mobile Card View --}}
        <div class="block sm:hidden space-y-3">
            @forelse($payments as $payment)
                <div x-on:click="$dispatch('open-modal', 'collection-payment-details-{{ $payment->id }}')" class="bg-white cursor-pointer rounded-xl border border-gray-200 shadow-sm p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $payment->student_name }}</h4>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                {{ $payment->year_level ?? '1st Year' }}
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
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No records found for {{ $course }}</h3>
                    <p class="mt-1 text-sm text-gray-500">There are no payments recorded for this course.</p>
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Year Level</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Recorded By</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($payments as $payment)
                            <tr x-on:click="$dispatch('open-modal', 'collection-payment-details-{{ $payment->id }}')" class="hover:bg-gray-50 cursor-pointer transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $payment->student_name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $payment->year_level ?? '1st Year' }}
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No records found for {{ $course }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">There are no payments recorded for this course.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @forelse($payments as $payment)
            <x-modal :name="'collection-payment-details-'.$payment->id" maxWidth="md">
                <div class="bg-white">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Payment Details</h3>
                            <p class="text-sm text-gray-500">Record #{{ $payment->id }}</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-600" x-on:click="$dispatch('close-modal', 'collection-payment-details-{{ $payment->id }}')" title="Close">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Student Name</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $payment->student_name }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Year Level</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $payment->year_level ?? '1st Year' }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Amount</p>
                                <p class="mt-1 text-sm font-semibold text-green-600">₱{{ number_format($payment->amount, 2) }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Payment Date</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($payment->date)->format('F d, Y') }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 md:col-span-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Description</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $payment->description }}</p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Recorded By</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">
                                    @if($payment->recorded_by_name)
                                        {{ $payment->recorded_by_name }} <span class="text-blue-500 font-bold">(File)</span>
                                    @else
                                        {{ $payment->recorder->name ?? 'Unknown' }}
                                    @endif
                                </p>
                            </div>

                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Record Created</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $payment->created_at ? $payment->created_at->format('F d, Y g:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end">
                        <button type="button" class="px-4 py-2 bg-green-600 text-white text-sm font-bold rounded-lg hover:bg-green-700 transition" x-on:click="$dispatch('close-modal', 'collection-payment-details-{{ $payment->id }}')">
                            Close
                        </button>
                    </div>
                </div>
            </x-modal>
        @empty
        @endforelse

        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row items-center justify-between bg-white p-3 sm:p-4 border border-gray-200 rounded-lg shadow-sm gap-3">
            <div class="text-xs sm:text-sm text-gray-700">
                Showing <span class="font-medium">{{ $payments->firstItem() ?? 0 }}</span> 
                to <span class="font-medium">{{ $payments->lastItem() ?? 0 }}</span> 
                of <span class="font-medium">{{ $payments->total() }}</span> results
            </div>
            <div class="pagination-white">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
