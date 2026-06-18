<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Archived Payment Records') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8 px-0 sm:px-4 lg:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 sm:mb-10 pb-4 sm:pb-6 border-b border-gray-100 gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gray-600 rounded-lg shadow-gray-200 shadow-lg flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900 lg:text-3xl">
                            Archived Records
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">
                            View and restore deleted payment records.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                <form action="{{ route('payments.archived') }}" method="GET" class="relative flex items-center group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search records..." 
                        class="block w-full sm:w-64 pl-10 pr-12 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50/50 transition-all">
                    
                    @if(request('search'))
                        <a href="{{ route('payments.archived') }}" class="absolute right-3 text-xs font-bold text-red-500 hover:text-red-700">
                            CLEAR
                        </a>
                    @endif
                </form>

                <a href="{{ route('payments.index') }}" 
                class="inline-flex items-center justify-center px-4 sm:px-5 py-2.5 bg-gray-100 text-gray-700 text-xs sm:text-sm font-bold rounded-xl border border-gray-300 hover:bg-gray-200 hover:-translate-y-0.5 transition-all active:scale-95">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Active Records
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

        @if($batches->isEmpty())
            <div class="bg-white shadow-md rounded-xl p-8 sm:p-12 text-center border border-gray-200">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No Archives Found</h3>
                <p class="mt-2 text-sm text-gray-500">You haven't archived any payment batches yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($batches as $batch)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                        <div class="p-4 sm:p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-start">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="p-2 bg-yellow-100 rounded-lg text-yellow-600 flex-shrink-0">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 truncate" title="{{ $batch->archive_batch_name ?? 'Uncategorized' }}">
                                        {{ $batch->archive_batch_name ?? 'Uncategorized' }}
                                    </h3>
                                    <p class="text-xs text-gray-500 font-medium">
                                        Archived: {{ \Carbon\Carbon::parse($batch->archived_date)->format('M d, Y g:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4 sm:p-5 space-y-3 sm:space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-xs sm:text-sm text-gray-500 font-medium">Total Records</span>
                                <span class="text-xs sm:text-sm font-bold text-gray-900 bg-gray-100 px-2.5 py-0.5 rounded-full">
                                    {{ $batch->total_records }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                <span class="text-xs sm:text-sm text-gray-500 font-medium">Total Amount</span>
                                <span class="text-xs sm:text-sm font-bold text-green-600">
                                    ₱{{ number_format($batch->total_amount, 2) }}
                                </span>
                            </div>
                            
                            <div class="pt-2 flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('payments.archived.show', $batch->archive_batch_name ?? 'Uncategorized') }}" class="flex-1 inline-flex justify-center items-center px-3 sm:px-4 py-2 bg-white border border-blue-200 text-blue-600 rounded-lg text-xs sm:text-sm font-bold hover:bg-blue-50 hover:border-blue-300 transition-colors">
                                    <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Records
                                </a>

                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('payments.restoreBatch') }}" method="POST" onsubmit="return confirm('Are you sure you want to restore all records in this batch?')" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="batch_name" value="{{ $batch->archive_batch_name ?? 'N/A' }}">
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-3 sm:px-4 py-2 bg-white border border-green-200 text-green-600 rounded-lg text-xs sm:text-sm font-bold hover:bg-green-50 hover:border-green-300 transition-colors">
                                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <div class="flex-1 text-center px-4 py-2 bg-gray-50 border border-gray-200 text-gray-400 rounded-lg text-xs sm:text-sm font-medium">
                                        Admin access required
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row items-center justify-between bg-white p-3 sm:p-4 border border-gray-200 rounded-lg shadow-sm gap-3">
            <div class="text-xs sm:text-sm text-gray-700">
                Showing <span class="font-medium">{{ $batches->firstItem() ?? 0 }}</span> 
                to <span class="font-medium">{{ $batches->lastItem() ?? 0 }}</span> 
                of <span class="font-medium">{{ $batches->total() }}</span> batches
            </div>
            <div class="pagination-white">
                {{ $batches->links() }}
            </div>
        </div>
    </div>
</x-app-layout>