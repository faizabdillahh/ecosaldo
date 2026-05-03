<nav x-data="{ open: false }" class="bg-eco border-b border-eco-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-bold text-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    EcoSaldo
                </a>
                <div class="hidden sm:flex sm:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-eco-50">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-3">
                {{-- Notification --}}
                <a href="{{ route('notifications.index') }}" class="relative text-white hover:text-eco-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                {{-- Profile Dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-1 text-white hover:text-eco-50 text-sm font-medium">
                            <x-avatar :name="Auth::user()->name" size="sm" />
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profil</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                {{-- Hamburger --}}
                <button @click="open = !open" class="sm:hidden text-white hover:text-eco-50 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'block': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'block': open, 'hidden': !open}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="sm:hidden bg-eco border-t border-eco-700">
        <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-white text-sm font-medium">Dashboard</a>
        <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-white text-sm">Profil</a>
        <form method="POST" action="{{ route('logout') }}" class="block px-4 py-3">
            @csrf
            <button class="text-white text-sm">Keluar</button>
        </form>
        <div class="px-4 py-3 border-t border-eco-700 text-eco-50 text-xs">
            {{ Auth::user()->name }} · {{ Auth::user()->email }}
        </div>
    </div>
</nav>