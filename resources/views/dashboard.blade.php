<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'admin' ? __('Admin Dashboard') : __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 px-0 sm:px-6">
        <div class="mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-600 text-sm sm:text-base">Here is what's happening with the SSC records today.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 {{ auth()->user()->role === 'admin' ? 'lg:grid-cols-4' : 'lg:grid-cols-2' }} gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-green-100 rounded-lg mr-4 flex-shrink-0">
                    <span class="text-xl font-bold">₱</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase">Total Collected</p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800 truncate">₱{{ number_format($totalCollection, 2) }}</h3>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg mr-4 flex-shrink-0">
                    <span class="text-xl">🧾</span>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase">Transactions</p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $transactionCount }}</h3>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-purple-100 rounded-lg mr-4 flex-shrink-0">
                    <span class="text-xl">👤</span>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase">Active Users</p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $usersCount }}</h3>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg mr-4 flex-shrink-0">
                    <span class="text-xl">🎓</span>
                </div>
                <div>
                    <p class="text-xs sm:text-sm font-medium text-gray-500 uppercase">Total Courses</p>
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $courseCount }}</h3>
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Recent Payments Table -->
            <div class="{{ auth()->user()->role === 'admin' ? 'lg:col-span-2' : 'lg:col-span-3' }} bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-sm sm:text-base">Recent Payment Records</h3>
                    <a href="{{ route('payments.index') }}" class="text-xs sm:text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-xs font-bold text-gray-500 uppercase">Student</th>
                                <th class="px-4 sm:px-6 py-3 text-xs font-bold text-gray-500 uppercase">Amount</th>
                                <th class="px-4 sm:px-6 py-3 text-xs font-bold text-gray-500 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentPayments as $payment)
                            <tr>
                                <td class="px-4 sm:px-6 py-4 text-sm text-gray-700 font-medium whitespace-nowrap">{{ $payment->student_name }}</td>
                                <td class="px-4 sm:px-6 py-4 text-sm text-green-600 font-bold whitespace-nowrap">₱{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-4 sm:px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $payment->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                            @if($recentPayments->isEmpty())
                            <tr>
                                <td colspan="3" class="px-4 sm:px-6 py-4 text-center text-sm text-gray-500">No recent payments found.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <!-- Quick Actions -->
            <div class="space-y-6">
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('payments.create') }}" class="flex items-center p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition">
                            <span class="mr-3">➕</span> Add New Payment
                        </a>
                        <a href="{{ route('users.create') }}" class="flex items-center p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition">
                            <span class="mr-3">👤</span> Register New Officer
                        </a>
                        <a href="{{ route('courses.index') }}" class="flex items-center p-3 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition">
                            <span class="mr-3">📚</span> Manage Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
