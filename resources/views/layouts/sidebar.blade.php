<div class="flex flex-col w-64 bg-slate-900 min-h-screen text-gray-300">
    <div class="flex items-center justify-between h-16 bg-slate-950 border-b border-slate-800 px-4">
        <span class="text-white font-bold text-lg tracking-wider">SSC SYSTEM</span>
        {{-- Close button for mobile --}}
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white transition p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : '' }}"
           @click="sidebarOpen = false">
            <span class="mr-3">📊</span> Dashboard
        </a>

        <a href="{{ route('payments.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('payments.*') ? 'bg-blue-600 text-white' : '' }}"
           @click="sidebarOpen = false">
            <span class="mr-3">💰</span> Payment Records
        </a>

        <a href="{{ route('collections.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition {{ request()->routeIs('collections.index') ? 'bg-blue-600 text-white' : '' }}"
           @click="sidebarOpen = false">
            <span class="mr-3">📈</span> Total Collection
        </a>

        @if(auth()->user()->role === 'admin')
        <div class="pt-4 pb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider px-4">
            Administration
        </div>
        <a href="{{ route('users.index') }}" 
            class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('users.index') ? 'bg-blue-600 text-white' : '' }}"
            @click="sidebarOpen = false">
            <span class="mr-3">👤</span> Manage User
        </a>
       <a href="{{ route('courses.index') }}" 
            class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-800 transition {{ request()->routeIs('courses.index') ? 'bg-blue-600 text-white' : '' }}"
            @click="sidebarOpen = false">
            <span class="mr-3">📚</span> Manage Course
        </a>
        @endif
    </nav>

    <div class="p-4 border-t border-slate-800 text-xs text-center">
        Northlink Technological College © 2026
    </div>
</div>