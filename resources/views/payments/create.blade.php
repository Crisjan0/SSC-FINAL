<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Payment Record') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-4">
                <a href="{{ route('payments.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center text-sm font-medium">
                    ← Back to Payment List
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-lg sm:rounded-lg">
                <div class="p-4 sm:p-8 text-gray-900">
                    
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Student Name</label>
                                <input type="text" name="student_name" value="{{ old('student_name') }}" required 
                                       class="w-full capitalize border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('student_name') border-red-500 @enderror"
                                       placeholder="Enter full name">
                                @error('student_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select name="course" required 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('course') border-red-500 @enderror">
                                    
                                    <option value="" disabled selected>Select course</option>
                                    
                                    @foreach($courses as $course)
                                        <option value="{{ $course->abbreviation }}" 
                                            {{ old('course') == $course->abbreviation ? 'selected' : '' }}>
                                            {{ $course->abbreviation }}
                                        </option>
                                    @endforeach
                                    
                                </select>
                                @error('course') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
                                <select name="year_level" required 
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('year_level') border-red-500 @enderror">
                                    
                                    <option value="" disabled selected>Select year level</option>
                                    <option value="1st Year" {{ old('year_level') == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2nd Year" {{ old('year_level') == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3rd Year" {{ old('year_level') == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4th Year" {{ old('year_level') == '4th Year' ? 'selected' : '' }}>4th Year</option>
                                    
                                </select>
                                @error('year_level') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Amount (₱)</label>
                                <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="0.00">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date</label>
                                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                <input type="text" name="description" value="{{ old('description') }}" required 
                                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="e.g. Tuition, Fun Run, Lab Fee">
                            </div>

                        </div>

                        <div class="mt-8 flex items-center justify-end space-x-4 border-t pt-6">
                            <button type="reset" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Clear Form
                            </button>
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-md transition">
                                Save Payment Record
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>