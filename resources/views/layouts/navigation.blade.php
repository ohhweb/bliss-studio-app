<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <!-- <svg width="200" height="50" viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#FFB74D;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#FB8C00;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <g transform="translate(5, 5) scale(0.8)">
                            <path d="M20 0 L0 0 L0 40 L20 40 L20 25 C25 25 25 20 20 20 L0 20 M0 0 L20 0 L20 15 C25 15 25 20 20 20" 
                                fill="none" 
                                stroke="url(#logoGradient)" 
                                stroke-width="5" 
                                stroke-linecap="round" 
                                stroke-linejoin="round"/>
                            <path d="M30 0 L50 0 L50 40 L30 40 L30 25 C25 25 25 20 30 20 L50 20 M50 0 L30 0 L30 15 C25 15 25 20 30 20" 
                                fill="none" 
                                stroke="url(#logoGradient)" 
                                stroke-width="5" 
                                stroke-linecap="round" 
                                stroke-linejoin="round"/>
                        </g>
                        <text x="65" y="32" 
                                font-family="'Poppins', sans-serif" 
                                font-size="24" 
                                font-weight="600" 
                                fill="#8c8c8d">
                            Bliss Films
                        </text>
                        </svg> -->
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <div class="flex items-center ml-4">
                        <form method="GET" action="{{ route('search') }}">
                            <input type="text" name="query" placeholder="Search for videos..." class="border-gray-600 rounded-md py-1 px-2 text-sm focus:ring-amber-500 focus:border-amber-500">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown for Authenticated Users (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('watchlist.index')">
                                 {{ __('My Watchlist') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('history.index')">
                                 {{ __('Watched History') }}
                            </x-dropdown-link>
                            <!-- In navigation.blade.php dropdowns -->
                            <x-dropdown-link :href="route('admin.devices.index')">
                                {{ __('Manage Devices') }}
                            </x-dropdown-link>

                            <!-- Admin Links for Admin Users -->
                            @if(Auth::user()->is_admin)
                                <!-- CORRECTED ROUTE NAMES BELOW -->
                                <x-dropdown-link :href="route('admin.videos.index')">
                                    {{ __('Manage Videos') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.categories.index')">
                                    {{ __('Manage Categories') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    {{-- Login/Register Links for Guests (Desktop) --}}
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('watchlist.index')">
                        {{ __('My Watchlist') }}
                     </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('history.index')">
                        {{ __('Watched History') }}
                    </x-responsive-nav-link>
                    
                    <!-- Admin Links for Admin Users (Mobile) -->
                    @if(Auth::user()->is_admin)
                        <!-- CORRECTED ROUTE NAMES BELOW -->
                        <x-responsive-nav-link :href="route('admin.videos.index')">
                            {{ __('Manage Videos') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('admin.categories.index')">
                            {{ __('Manage Categories') }}
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                {{-- Login/Register Links for Guests (Mobile) --}}
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>