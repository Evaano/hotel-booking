<nav x-data="{ open: false }"
    class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-white/20 ring-1 ring-muted-200/50 shadow-soft">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:ms-10 sm:flex sm:items-center">
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>

                        @if (Auth::user()->isAdmin())
                            <!-- Admin Navigation Links -->
                            <x-nav-link :href="route('hotels.index')" :active="request()->routeIs('hotels.*')" class="hover:text-indigo-600">
                                Manage Hotels
                            </x-nav-link>
                            <x-nav-link :href="route('ferry.index')" :active="request()->routeIs('ferry.*')" class="hover:text-indigo-600">
                                Manage Ferry
                            </x-nav-link>
                            <x-nav-link :href="route('theme-park.manage')" :active="request()->routeIs('theme-park.*')" class="hover:text-indigo-600">
                                Manage Theme Park
                            </x-nav-link>
                            <x-nav-link :href="route('beach-events.manage')" :active="request()->routeIs('beach-events.*')" class="hover:text-indigo-600">
                                Manage Beach Events
                            </x-nav-link>
                        @elseif (Auth::user()->isHotelOperator())
                            <!-- Hotel Operator Navigation Links -->
                            <x-nav-link :href="route('hotels.index')" :active="request()->routeIs('hotels.*')">
                                My Hotels
                            </x-nav-link>
                            <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">
                                Rooms
                            </x-nav-link>
                        @elseif (Auth::user()->isFerryOperator())
                            <!-- Ferry Operator Navigation Links -->
                            <x-nav-link :href="route('ferry.schedules')" :active="request()->routeIs('ferry.schedules')">
                                Schedules
                            </x-nav-link>
                            <x-nav-link :href="route('ferry.tickets')" :active="request()->routeIs('ferry.tickets')">
                                Tickets
                            </x-nav-link>
                        @elseif (Auth::user()->isParkOperator())
                            <!-- Park Operator Navigation Links -->
                            <x-nav-link :href="route('theme-park.activities')" :active="request()->routeIs('theme-park.activities')">
                                Activities
                            </x-nav-link>
                            <x-nav-link :href="route('theme-park.tickets')" :active="request()->routeIs('theme-park.tickets')">
                                Tickets
                            </x-nav-link>
                        @elseif (Auth::user()->isBeachOrganizer())
                            <!-- Beach Organizer Navigation Links -->
                            <x-nav-link :href="route('beach-events.manage')" :active="request()->routeIs('beach-events.manage')">
                                My Events
                            </x-nav-link>
                            <x-nav-link :href="route('beach-events.manage-bookings')" :active="request()->routeIs('beach-events.manage-bookings')">
                                Participants
                            </x-nav-link>
                        @else
                            <!-- Visitor Navigation Links (booking flow order) -->
                            <x-nav-link :href="route('hotels.browse')" :active="request()->routeIs('hotels.*')">
                                Hotels
                            </x-nav-link>
                            <x-nav-link :href="route('ferry.schedules')" :active="request()->routeIs('ferry.*')">
                                Ferry
                            </x-nav-link>
                            <x-nav-link :href="route('theme-park.index')" :active="request()->routeIs('theme-park.*')">
                                Theme Park
                            </x-nav-link>
                            <x-nav-link :href="route('beach-events.index')" :active="request()->routeIs('beach-events.*')">
                                Beach Events
                            </x-nav-link>
                            <x-nav-link :href="route('map')" :active="request()->routeIs('map')">
                                Map
                            </x-nav-link>
                        @endif
                    @else
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            Home
                        </x-nav-link>
                        <x-nav-link :href="route('hotels.browse')" :active="request()->routeIs('hotels.*')">
                            Hotels
                        </x-nav-link>
                        <x-nav-link :href="route('ferry.schedules')" :active="request()->routeIs('ferry.*')">
                            Ferry
                        </x-nav-link>
                        <x-nav-link :href="route('theme-park.index')" :active="request()->routeIs('theme-park.*')">
                            Theme Park
                        </x-nav-link>
                        <x-nav-link :href="route('beach-events.index')" :active="request()->routeIs('beach-events.*')">
                            Beach Events
                        </x-nav-link>
                        <x-nav-link :href="route('map')" :active="request()->routeIs('map')">
                            Map
                        </x-nav-link>
                    @endauth
                    @guest
                        <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                            Contact
                        </x-nav-link>
                    @else
                        @if (Auth::user()->isVisitor())
                            <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                                Contact
                            </x-nav-link>
                        @endif
                    @endguest
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-breeze-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-xl text-muted-600 bg-white/60 backdrop-blur-sm ring-1 ring-muted-300/50 hover:text-muted-900 hover:bg-white hover:ring-muted-400/50 transition-all duration-200">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.show')">
                                Profile
                            </x-dropdown-link>
                            @if (Auth::user()->isVisitor())
                                <x-dropdown-link :href="route('my.bookings')">
                                    My Bookings
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-breeze-dropdown>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary uppercase text-xs">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-responsive-nav-link>

                @if (Auth::user()->isAdmin())
                    <!-- Admin Navigation Links -->
                    <x-responsive-nav-link :href="route('hotels.index')" :active="request()->routeIs('hotels.*')">
                        Manage Hotels
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('ferry.index')" :active="request()->routeIs('ferry.*')">
                        Manage Ferry
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('theme-park.manage')" :active="request()->routeIs('theme-park.*')">
                        Manage Theme Park
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('beach-events.manage')" :active="request()->routeIs('beach-events.*')">
                        Manage Beach Events
                    </x-responsive-nav-link>
                @elseif (Auth::user()->isHotelOperator())
                    <!-- Hotel Operator Navigation Links -->
                    <x-responsive-nav-link :href="route('hotels.index')" :active="request()->routeIs('hotels.*')">
                        My Hotels
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">
                        Rooms
                    </x-responsive-nav-link>
                @elseif (Auth::user()->isFerryOperator())
                    <!-- Ferry Operator Navigation Links -->
                    <x-responsive-nav-link :href="route('ferry.schedules')" :active="request()->routeIs('ferry.schedules')">
                        Schedules
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('ferry.tickets')" :active="request()->routeIs('ferry.tickets')">
                        Tickets
                    </x-responsive-nav-link>
                @elseif (Auth::user()->isParkOperator())
                    <!-- Park Operator Navigation Links -->
                    <x-responsive-nav-link :href="route('theme-park.activities')" :active="request()->routeIs('theme-park.activities')">
                        Activities
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('theme-park.tickets')" :active="request()->routeIs('theme-park.tickets')">
                        Tickets
                    </x-responsive-nav-link>
                @elseif (Auth::user()->isBeachOrganizer())
                    <!-- Beach Organizer Navigation Links -->
                    <x-responsive-nav-link :href="route('beach-events.manage')" :active="request()->routeIs('beach-events.manage')">
                        My Events
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('beach-events.manage-bookings')" :active="request()->routeIs('beach-events.manage-bookings')">
                        Participants
                    </x-responsive-nav-link>
                @else
                    <!-- Visitor Navigation Links (booking flow order) -->
                    <x-responsive-nav-link :href="route('hotels.browse')" :active="request()->routeIs('hotels.*')">
                        Hotels
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('ferry.schedules')" :active="request()->routeIs('ferry.*')">
                        Ferry
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('theme-park.index')" :active="request()->routeIs('theme-park.*')">
                        Theme Park
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('beach-events.index')" :active="request()->routeIs('beach-events.*')">
                        Beach Events
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('map')" :active="request()->routeIs('map')">
                        Map
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    Home
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('hotels.browse')" :active="request()->routeIs('hotels.*')">
                    Hotels
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ferry.schedules')" :active="request()->routeIs('ferry.*')">
                    Ferry
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('theme-park.index')" :active="request()->routeIs('theme-park.*')">
                    Theme Park
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('beach-events.index')" :active="request()->routeIs('beach-events.*')">
                    Beach Events
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('map')" :active="request()->routeIs('map')">
                    Map
                </x-responsive-nav-link>
            @endauth
            @guest
                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                    Contact
                </x-responsive-nav-link>
            @else
                @if (Auth::user()->isVisitor())
                    <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                        Contact
                    </x-responsive-nav-link>
                @endif
            @endguest
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-900">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.show')">
                        Profile
                    </x-responsive-nav-link>
                    @if (Auth::user()->isVisitor())
                        <x-responsive-nav-link :href="route('my.bookings')">
                            My Bookings
                        </x-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            Log Out
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('login')">
                        Login
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        Register
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>
