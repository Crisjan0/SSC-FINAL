<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Payment Record') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12 px-4 sm:px-6">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-4">
                <a href="{{ route('payments.index') }}" class="text-blue-600 hover:underline text-sm flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Back to Payment List
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 sm:p-8">
                    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT') 
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wide text-xs">Student Name</label>
                                <input type="text" name="student_name" value="{{ old('student_name', $payment->student_name) }}" required 
                                       class="w-full capitalize border-gray-200 rounded-lg focus:ring-blue-500 @error('student_name') border-red-500 @enderror">
                                @error('student_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wide text-xs">Course</label>
                                <select name="course" required 
                                        class="w-full border-gray-200 rounded-lg focus:ring-blue-500 @error('course') border-red-500 @enderror">
                                    <option value="" disabled>Select course</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->abbreviation }}" 
                                            {{ old('course', $payment->course) == $course->abbreviation ? 'selected' : '' }}>
                                            {{ $course->abbreviation }} - {{ $course->course_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wide text-xs">Year Level</label>
                                <select name="year_level" required 
                                        class="w-full border-gray-200 rounded-lg focus:ring-blue-500">
                                    <option value="" disabled>Select year level</option>
                                    @foreach(['1st Year', '2nd Year', '3rd Year', '4th Year'] as $year)
                                        <option value="{{ $year }}" {{ old('year_level', $payment->year_level) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wide text-xs">Amount (₱)</label>
                                <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}" required 
                                       class="w-full border-gray-200 rounded-lg focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wide text-xs">Date</label>
                                <input type="date" name="date" value="{{ old('date', $payment->date) }}" required 
                                       class="w-full border-gray-200 rounded-lg focus:ring-blue-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-1 uppercase tracking-wide text-xs">Description</label>
                                <input type="text" name="description" value="{{ old('description', $payment->description) }}" required 
                                       class="w-full border-gray-200 rounded-lg focus:ring-blue-500" placeholder="e.g. Monthly Dues, ID Fee">
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end space-x-3">
                            <a href="{{ route('payments.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                Cancel
                            </a>
                            <button type="submit" class="px-8 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-md transition transform active:scale-95">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>