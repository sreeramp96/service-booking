<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ auth()->user()->role === 'provider' ? route('provider.dashboard') : route('customer.dashboard') }}"
                    class="flex items-center space-x-2">
                    {{-- <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a> --}}
                    @if(auth()->user()->role === 'provider')
                        <span class="text-xl font-semibold text-blue-700"><a
                                href="{{ route('provider.dashboard') }}">ServiceBook</a></span>
                    @else
                        <span class="text-xl font-semibold text-blue-700"><a
                                href="{{ route('customer.dashboard') }}">ServiceBook</a></span>
                    @endif
                </a>

                <div class="hidden sm:flex space-x-6">
                    @if(auth()->user()->role === 'provider')
                        {{-- <a href="{{ route('provider.dashboard') }}"
                            class="nav-link {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a> --}}
                        <a href="{{ route('services.index') }}"
                            class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                            Services
                        </a>
                        <a href="{{ route('availabilities.index') }}"
                            class="nav-link {{ request()->routeIs('availabilities.*') ? 'active' : '' }}">
                            Availability
                        </a>
                    @else
                        {{-- <a href="{{ route('customer.dashboard') }}"
                            class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a> --}}
                        {{-- <a href="{{ route('services.index') }}"
                            class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}">
                            Browse
                        </a> --}}
                        {{-- <a href="{{ route('bookings.history') }}"
                            class="nav-link {{ request()->routeIs('bookings.*') ? 'active' : '' }}">
                            Bookings
                        </a> --}}
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex items-center space-x-4">
                <div class="text-sm text-gray-700 dark:text-gray-200 font-medium">{{ Auth::user()->name }}</div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="focus:outline-none">
                            <svg class="w-5 h-5 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="text-gray-600 dark:text-gray-400 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Nav -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden px-4 pb-4">
        <div class="space-y-1 pt-2">
            @if(auth()->user()->role === 'provider')
                {{-- <x-responsive-nav-link :href="route('provider.dashboard')">Dashboard</x-responsive-nav-link> --}}
                <x-responsive-nav-link :href="route('services.index')">Services</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('availabilities.index')">Availability</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('customer.dashboard')">Dashboard</x-responsive-nav-link>
                {{-- <x-responsive-nav-link :href="route('services.index')">Browse</x-responsive-nav-link> --}}
                {{-- <x-responsive-nav-link :href="route('bookings.history')">Bookings</x-responsive-nav-link> --}}
            @endif
            <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>