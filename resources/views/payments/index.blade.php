<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Payment Records') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-8 px-0 sm:px-4 lg:px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 sm:mb-10 pb-4 sm:pb-6 border-b border-gray-100 gap-4">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-600 rounded-lg shadow-blue-200 shadow-lg flex-shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight text-gray-900 lg:text-3xl">
                            Payment Records
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium">
                            Manage student transactions and data exports.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3">
                <form action="{{ route('payments.index') }}" method="GET" class="relative flex items-center group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search records..." 
                        class="block w-full sm:w-64 pl-10 pr-12 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50/50 transition-all">
                    
                    @if(request('search'))
                        <a href="{{ route('payments.index') }}" class="absolute right-3 text-xs font-bold text-red-500 hover:text-red-700">
                            CLEAR
                        </a>
                    @endif
                </form>

                <div class="flex items-center justify-between sm:justify-start gap-2">
                    <div class="flex items-center bg-gray-100/80 p-1 rounded-xl border border-gray-200">
                        <a href="{{ route('payments.export') }}" 
                        class="p-2 text-gray-600 hover:bg-white hover:text-blue-600 rounded-lg transition-all hover:shadow-sm" 
                        title="Export CSV">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>

                        <form action="{{ route('payments.import') }}" method="POST" enctype="multipart/form-data" class="flex">
                            @csrf
                            <input type="file" name="file" accept=".csv" class="hidden" id="csv_import" onchange="this.form.submit()">
                            <label for="csv_import" class="p-2 cursor-pointer text-gray-600 hover:bg-white hover:text-blue-600 rounded-lg transition-all hover:shadow-sm" title="Import CSV">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </label>
                        </form>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        @if(auth()->user()->role === 'admin')
                        <button type="button" onclick="document.getElementById('archiveModal').classList.remove('hidden')" class="inline-flex items-center px-3 sm:px-4 py-2.5 bg-yellow-100 text-yellow-700 text-xs sm:text-sm font-bold rounded-xl border border-yellow-300 hover:bg-yellow-200 transition-all" title="Archive All">
                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            <span class="hidden sm:inline">Archive All</span>
                            <span class="sm:hidden">Archive</span>
                        </button>

                        <a href="{{ route('payments.archived') }}" 
                        class="inline-flex items-center px-3 sm:px-4 py-2.5 bg-gray-100 text-gray-700 text-xs sm:text-sm font-bold rounded-xl border border-gray-300 hover:bg-gray-200 transition-all">
                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                            Archives
                        </a>
                        @endif

                        <a href="{{ route('payments.create') }}" 
                        class="inline-flex items-center px-4 sm:px-5 py-2.5 bg-blue-600 text-white text-xs sm:text-sm font-bold rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:-translate-y-0.5 transition-all active:scale-95">
                            <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Payment
                        </a>
                    </div>
                </div>
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
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <div class="space-y-1">
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
                        <div class="flex items-center gap-3 ml-2">
                            <a href="{{ route('payments.edit', $payment->id) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to archive this record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-yellow-600 hover:text-yellow-900 transition" title="Archive">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                </button>
                            </form>
                            <form action="{{ route('payments.forceDelete', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to PERMANENTLY DELETE this record? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition" title="Permanent Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No records found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new payment record.</p>
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
                                                {{-- Get initials from file name OR system user --}}
                                                {{ strtoupper(substr($payment->recorded_by_name ?? $payment->recorder->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <span>
                                            {{-- Prioritize the name from the Import File --}}
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
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="text-blue-600 hover:text-blue-900 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to archive this record?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900 transition flex items-center gap-1 font-semibold" title="Archive">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('payments.forceDelete', $payment->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to PERMANENTLY DELETE this record? This cannot be undone.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition flex items-center gap-1 font-semibold" title="Permanent Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
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
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new payment record.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row items-center justify-between bg-white p-3 sm:p-4 border border-gray-200 rounded-lg shadow-sm gap-3">
            <div class="text-xs sm:text-sm text-gray-700">
                Showing <span class="font-medium">{{ $payments->firstItem() }}</span> 
                to <span class="font-medium">{{ $payments->lastItem() }}</span> 
                of <span class="font-medium">{{ $payments->total() }}</span> results
            </div>
            <div class="pagination-white">
                {{ $payments->links() }}
            </div>
        </div>
    </div>

    <!-- Archive Modal -->
    <div id="archiveModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-[calc(100%-2rem)] sm:w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Archive All Records</h3>
                <div class="mt-2 px-4 sm:px-7 py-3">
                    <p class="text-sm text-gray-500 mb-4">
                        Please provide a batch name for this archive (e.g., "1st Semester 2026").
                    </p>
                    <form id="archiveForm" action="{{ route('payments.archiveAll') }}" method="POST">
                        @csrf
                        <input type="text" name="archive_batch_name" required placeholder="Batch Name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <div class="items-center px-4 py-3 mt-4 flex gap-2 justify-end">
                            <button type="button" onclick="document.getElementById('archiveModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-yellow-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                                Archive
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>