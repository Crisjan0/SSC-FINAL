<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Total Collection by Course') }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-10 pb-6 border-b border-gray-100">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-600 rounded-lg shadow-green-200 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
                            Total Collections
                        </h2>
                        <p class="text-sm text-gray-500 font-medium">
                            Overview of total amount collected for each course.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courseCollections as $collection)
                <a href="{{ route('collections.show', $collection->course ?: 'unknown') }}" class="block bg-white rounded-xl p-6 border border-gray-200 shadow-sm hover:shadow-md transition duration-200 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 w-24 h-24 bg-green-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-green-100 text-green-700 rounded-xl flex items-center justify-center text-xl font-bold shadow-sm">
                                {{ substr($collection->course ?: '?', 0, 1) }}
                            </div>
                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                Course
                            </span>
                        </div>
                        <h4 class="text-xl font-extrabold text-gray-900 mb-1">{{ $collection->course ?: 'Unknown' }}</h4>
                        <div class="mt-6 pt-4 border-t border-gray-100 flex items-end justify-between">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Total Collected</p>
                                <p class="text-3xl font-black text-green-600">₱{{ number_format($collection->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 px-4 bg-white rounded-xl border border-gray-200 shadow-sm text-center">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-gray-100 mb-4">
                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">No Collections Yet</h3>
                    <p class="text-gray-500">There are no payment records in the system to calculate totals from.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
