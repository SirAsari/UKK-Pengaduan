<nav x-data="{ open: false }" class="bg-white shadow-md sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-blue-600 hover:text-blue-700">
                        <span class="font-extrabold">PengaduanKu</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:flex sm:ml-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-800 hover:text-blue-600">
                        {{ __('Home') }}
                    </x-nav-link>
                    @if(auth()->check() && auth()->user()->role === 'USER')
                    <x-nav-link :href="route('user.reports')" :active="request()->routeIs('user-reports')" class="text-gray-800 hover:text-blue-600">
                        {{ __('Reports') }}
                    </x-nav-link>
                    @endif
                    @if(auth()->check() && (auth()->user()->role === 'STAFF' || auth()->user()->role === 'HEAD_STAFF'))
                    <x-nav-link :href="route('report.index')" :active="request()->routeIs('report')" class="text-gray-800 hover:text-blue-600">
                        {{ __('Reports') }}
                    </x-nav-link>
                    @endif
                    @if(auth()->check() && auth()->user()->role === 'HEAD_STAFF')
                        <x-nav-link :href="route('staff-management.index')" :active="request()->routeIs('staff-management.*')" class="text-gray-800 hover:text-blue-600">
                            {{ __('User Management') }}
                        </x-nav-link>
                        <x-nav-link :href="route('head-staff.dashboard')" :active="request()->routeIs('head-staff.*')" class="text-gray-800 hover:text-blue-600">
                            {{ __('Lihat Chart') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @if (Auth::user())
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        @endif
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-100">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-700 hover:bg-gray-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger for Mobile -->
            <div class="sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if (!Auth::user())
            <div class="mt-4 sm:mt-0 space-x-4">
                <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                    Register
                </a>
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                    Login
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="sm:hidden">
        <div class="space-y-1 px-2 pt-2 pb-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-700 hover:bg-gray-100">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user())
            <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-100">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-700 hover:bg-gray-100">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
            @endif
        </div>
    </div>
</nav>
