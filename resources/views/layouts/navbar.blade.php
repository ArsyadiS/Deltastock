<header class="h-[70px] bg-zinc-950 border-b border-zinc-800 px-6 flex items-center justify-between shrink-0">

    <div class="flex items-center gap-4">
        {{-- Burger Button --}}
        <button @click="sidebarOpen = !sidebarOpen"
            class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/[0.05] transition-all">
            <svg class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        @isset($header)
            <div class="text-white font-semibold text-base tracking-tight ml-2">{{ $header }}</div>
        @endisset
    </div>

    <div class="flex items-center gap-4">
        {{-- Notification --}}
        <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-white/[0.03] hover:bg-white/[0.08] border border-white/[0.05] transition-all">
            <svg class="w-5 h-5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-indigo-500 rounded-full border-2 border-zinc-950"></span>
        </button>

        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="flex items-center gap-3 pl-2 py-1 pr-1 rounded-xl hover:bg-white/[0.03] transition-all">
                    <div class="flex flex-col items-end hidden md:flex">
                        <span class="text-sm font-semibold text-white leading-none">{{ Auth::user()?->name }}</span>
                        <span class="text-[11px] text-zinc-500 mt-1 uppercase tracking-wider">{{ Auth::user()?->getRoleNames()->first() }}</span>
                    </div>
                    <div class="w-9 h-9 rounded-lg bg-indigo-500 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-indigo-500/20">
                        {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                    </div>
                </button>
            </x-slot>
            
            <x-slot name="content">
                <div class="px-4 py-3 border-b border-zinc-800 bg-zinc-900">
                    <p class="text-[10px] uppercase tracking-widest text-zinc-500 font-bold">Signed in as</p>
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()?->email }}</p>
                </div>
                <div class="bg-zinc-900">
                    <x-dropdown-link :href="route('profile.edit')" class="hover:bg-white/5">Profile</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="hover:bg-red-500/10 hover:text-red-500">
                            Log Out
                        </x-dropdown-link>
                    </form>
                </div>
            </x-slot>
        </x-dropdown>
    </div>
</header>