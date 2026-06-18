<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Manage Courses') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 px-0 sm:px-6">
        <div class="mb-6">
            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Course Management</h2>
            <p class="text-gray-600 text-xs sm:text-sm">Add or remove academic courses offered in the college.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-100 h-fit">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Add New Course</h3>
                <form action="{{ route('courses.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Course Abbreviation</label>
                            <input type="text" name="abbreviation" placeholder="e.g. BSIS" required 
                                class="w-full rounded-lg border-gray-200 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Course Name</label>
                            <input type="text" name="course_name" placeholder="e.g. BS in Information Systems" required 
                                class="w-full rounded-lg border-gray-200 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                            Save Course
                        </button>
                    </div>
                </form>
            </div>

            {{-- Mobile Card View --}}
            <div class="lg:col-span-2 block sm:hidden space-y-3">
                @forelse($courses as $course)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between">
                        <div class="min-w-0 flex-1">
                            <span class="text-sm font-bold text-blue-600">{{ $course->abbreviation }}</span>
                            <p class="text-sm text-gray-700 truncate">{{ $course->course_name }}</p>
                        </div>
                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="ml-3 flex-shrink-0">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700" onclick="return confirm('Delete this course?')">
                                🗑️
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center text-gray-400 italic">
                        No courses added yet.
                    </div>
                @endforelse
            </div>

            {{-- Desktop Table View --}}
            <div class="lg:col-span-2 hidden sm:block bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500">Abbreviation</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500">Full Name</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($courses as $course)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-bold text-blue-600">{{ $course->abbreviation }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $course->course_name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700" onclick="return confirm('Delete this course?')">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400 italic">No courses added yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>