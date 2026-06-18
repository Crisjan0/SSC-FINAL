<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
            {{ __('Manage Officers') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 px-0 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Officer Management</h2>
                <p class="text-gray-600 text-xs sm:text-sm">Manage existing accounts or create new officer access.</p>
            </div>
            
            <a href="{{ route('users.create') }}" 
               class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create User Account
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Mobile Card View --}}
        <div class="block sm:hidden space-y-3">
            @forelse($users as $user)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-bold text-gray-900 truncate">{{ $user->name }}</h4>
                            <p class="text-xs text-gray-500 italic truncate mt-0.5">{{ $user->email }}</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold ml-2 flex-shrink-0 {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ strtoupper($user->role) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-semibold underline decoration-dotted">
                                Switch to {{ $user->role === 'admin' ? 'User' : 'Admin' }}
                            </button>
                        </form>
                        <span class="text-gray-300">|</span>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition" onclick="return confirm('Remove this officer account?')">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                    <p class="text-gray-400 italic">No officers found. Click "Create User Account" to start.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden sm:block bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-800">Existing Officers</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500">Officer Name</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500">System Email</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500">Role</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase text-gray-500 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 italic">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                                            <button type="submit" class="text-xs text-blue-600 hover:text-blue-800 font-semibold underline decoration-dotted">
                                                Switch to {{ $user->role === 'admin' ? 'User' : 'Admin' }}
                                            </button>
                                        </form>

                                        <span class="text-gray-300">|</span>

                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" onclick="return confirm('Remove this officer account?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">
                                    No officers found. Click "Create User Account" to start.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>