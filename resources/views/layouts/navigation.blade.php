<nav x-data="{ open: false, userDropdown: false }"
    class="bg-white/95 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left side - Logo & Navigation -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ auth()->user()->role === 'provider' ? route('provider.dashboard') : route('customer.dashboard') }}"
                    class="flex items-center space-x-2 group">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                        <span class="text-white font-bold text-xl">S</span>
                    </div>
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        ServiceBook
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-1">
                    @if (auth()->user()->role === 'provider')
                        <!-- Provider Navigation -->
                        <a href="{{ route('provider.dashboard') }}"
                            class="nav-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">🏠</span>
                            Dashboard
                        </a>
                        <a href="{{ route('services.index') }}"
                            class="nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                            <span class="nav-icon">⚙️</span>
                            My Services
                        </a>
                        <a href="#" class="nav-item">
                            <span class="nav-icon">📊</span>
                            Analytics
                            <span class="coming-soon-badge">Soon</span>
                        </a>
                        <a href="#" class="nav-item">
                            <span class="nav-icon">💰</span>
                            Earnings
                            <span class="coming-soon-badge">Soon</span>
                        </a>
                    @else
                        <!-- Customer Navigation -->
                        <a href="{{ route('customer.dashboard') }}"
                            class="nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                            <span class="nav-icon">🏠</span>
                            Dashboard
                        </a>
                        <a href="{{ route('services.index') }}"
                            class="nav-item {{ request()->routeIs('services.*') && !request()->routeIs('services.availabilities.*') ? 'active' : '' }}">
                            <span class="nav-icon">🔍</span>
                            Browse Services
                        </a>
                        @if (Route::has('favorites.index'))
                            <a href="{{ route('favorites.index') }}"
                                class="nav-item {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                                <span class="nav-icon">❤️</span>
                                Favorites
                            </a>
                        @endif
                        @if (Route::has('messages.index'))
                            <a href="{{ route('messages.index') }}"
                                class="nav-item {{ request()->routeIs('messages.*') ? 'active' : '' }} relative">
                                <span class="nav-icon">💬</span>
                                Messages
                                @if (isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                                    <span
                                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                        {{ $unreadMessagesCount > 9 ? '9+' : $unreadMessagesCount }}
                                    </span>
                                @endif
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Right side - User Profile & Actions -->
            <div class="hidden sm:flex items-center space-x-4">
                <!-- Quick Actions for Customers -->
                @if (auth()->user()->role === 'customer')
                    <a href="{{ route('services.index') }}" class="quick-action-btn">
                        <span class="text-lg">🔍</span>
                        Book Service
                    </a>
                @endif

                <!-- Notifications -->
                <div class="relative">
                    <button class="notification-btn">
                        <span class="text-lg">🔔</span>
                        <span class="notification-badge">3</span>
                    </button>
                </div>

                <!-- User Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="user-profile-btn">
                        <div class="user-avatar">
                            <span class="text-sm font-semibold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.away="open = false" class="dropdown-menu">

                        <!-- User Info Header -->
                        <div class="dropdown-header">
                            <div class="flex items-center space-x-3">
                                <div class="user-avatar-large">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                    <div class="text-xs text-blue-600 font-medium">{{ ucfirst(Auth::user()->role) }}
                                        Account</div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>

                        <!-- Quick Stats for Provider -->
                        @if (auth()->user()->role === 'provider')
                            <div class="dropdown-section">
                                <div class="grid grid-cols-2 gap-4 p-3 bg-gray-50 rounded-lg">
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-blue-600">12</div>
                                        <div class="text-xs text-gray-600">Services</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-bold text-green-600">₹24K</div>
                                        <div class="text-xs text-gray-600">This Month</div>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endif

                        <!-- Menu Items -->
                        <div class="dropdown-section">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <span class="dropdown-icon">👤</span>
                                <span>Profile Settings</span>
                            </a>

                            @if (auth()->user()->role === 'customer')
                                @if (Route::has('reviews.index'))
                                    <a href="{{ route('reviews.index') }}" class="dropdown-item">
                                        <span class="dropdown-icon">⭐</span>
                                        <span>My Reviews</span>
                                    </a>
                                @endif
                                <a href="#" class="dropdown-item">
                                    <span class="dropdown-icon">🎯</span>
                                    <span>Preferences</span>
                                    <span class="coming-soon-badge">Soon</span>
                                </a>
                            @else
                                <a href="#" class="dropdown-item">
                                    <span class="dropdown-icon">📈</span>
                                    <span>Performance</span>
                                    <span class="coming-soon-badge">Soon</span>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <span class="dropdown-icon">⚙️</span>
                                    <span>Business Settings</span>
                                    <span class="coming-soon-badge">Soon</span>
                                </a>
                            @endif

                            <a href="#" class="dropdown-item">
                                <span class="dropdown-icon">🎨</span>
                                <span>Theme</span>
                                <span class="coming-soon-badge">Soon</span>
                            </a>
                        </div>

                        <div class="dropdown-divider"></div>

                        <!-- Support & Logout -->
                        <div class="dropdown-section">
                            <a href="#" class="dropdown-item">
                                <span class="dropdown-icon">❓</span>
                                <span>Help & Support</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="dropdown-item text-red-600 hover:text-red-700 hover:bg-red-50 w-full text-left">
                                    <span class="dropdown-icon">🚪</span>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="mobile-menu-btn">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div :class="{ 'block': open, 'hidden': !open }" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" class="hidden sm:hidden bg-white border-t border-gray-100">

        <!-- User Info Mobile -->
        <div class="mobile-user-section">
            <div class="flex items-center space-x-3">
                <div class="user-avatar-large">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-blue-600">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Items -->
        <div class="mobile-nav-section">
            @if (auth()->user()->role === 'provider')
                <a href="{{ route('provider.dashboard') }}"
                    class="mobile-nav-item {{ request()->routeIs('provider.dashboard') ? 'active' : '' }}">
                    <span class="text-xl">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('services.index') }}"
                    class="mobile-nav-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
                    <span class="text-xl">⚙️</span>
                    <span>My Services</span>
                </a>
            @else
                <a href="{{ route('customer.dashboard') }}"
                    class="mobile-nav-item {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                    <span class="text-xl">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('services.index') }}" class="mobile-nav-item">
                    <span class="text-xl">🔍</span>
                    <span>Browse Services</span>
                </a>
                @if (Route::has('favorites.index'))
                    <a href="{{ route('favorites.index') }}" class="mobile-nav-item">
                        <span class="text-xl">❤️</span>
                        <span>Favorites</span>
                    </a>
                @endif
                @if (Route::has('messages.index'))
                    <a href="{{ route('messages.index') }}" class="mobile-nav-item relative">
                        <span class="text-xl">💬</span>
                        <span>Messages</span>
                        @if (isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span class="notification-badge-mobile">{{ $unreadMessagesCount }}</span>
                        @endif
                    </a>
                @endif
            @endif

            <a href="{{ route('profile.edit') }}" class="mobile-nav-item">
                <span class="text-xl">👤</span>
                <span>Profile</span>
            </a>
        </div>

        <!-- Mobile Logout -->
        <div class="mobile-logout-section">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-logout-btn">
                    <span class="text-xl">🚪</span>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </div>
</nav>

<style>
    /* Navigation Styles */
    .nav-item {
        @apply flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200 relative;
    }

    .nav-item.active {
        @apply text-blue-600 bg-blue-50;
    }

    .nav-icon {
        @apply text-base;
    }

    .coming-soon-badge {
        @apply absolute -top-1 -right-1 bg-orange-500 text-white text-xs px-1.5 py-0.5 rounded-full font-bold;
    }

    .quick-action-btn {
        @apply flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200 text-sm font-medium;
    }

    .notification-btn {
        @apply relative p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200;
    }

    .notification-badge {
        @apply absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold;
    }

    .user-profile-btn {
        @apply flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-all duration-200;
    }

    .user-avatar {
        @apply w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center;
    }

    .user-avatar-large {
        @apply w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold;
    }

    .user-info {
        @apply text-left;
    }

    .user-name {
        @apply text-sm font-semibold text-gray-900;
    }

    .user-role {
        @apply text-xs text-gray-500;
    }

    .dropdown-menu {
        @apply absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50;
    }

    .dropdown-header {
        @apply px-4 py-3;
    }

    .dropdown-section {
        @apply px-2;
    }

    .dropdown-divider {
        @apply border-t border-gray-100 my-2;
    }

    .dropdown-item {
        @apply flex items-center justify-between px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-all duration-200 mx-1;
    }

    .dropdown-icon {
        @apply text-base mr-3;
    }

    .mobile-menu-btn {
        @apply text-gray-600 hover:text-blue-600 focus:outline-none p-2;
    }

    .mobile-user-section {
        @apply px-4 py-4 border-b border-gray-100;
    }

    .mobile-nav-section {
        @apply px-2 py-2;
    }

    .mobile-nav-item {
        @apply flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-200 relative;
    }

    .mobile-nav-item.active {
        @apply text-blue-600 bg-blue-50;
    }

    .notification-badge-mobile {
        @apply absolute top-2 right-4 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold;
    }

    .mobile-logout-section {
        @apply px-2 py-2 border-t border-gray-100;
    }

    .mobile-logout-btn {
        @apply flex items-center space-x-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-all duration-200 w-full text-left;
    }
</style>
