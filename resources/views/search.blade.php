@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-900">Search Results</h1>
            <p class="text-xl text-gray-600">
                Found results for "{{ $query }}"
            </p>
        </div>

        <!-- Search Form -->
        <div class="card max-w-2xl mx-auto">
            <div class="card-body">
                <form
                    action="{{ route("search") }}"
                    method="GET"
                    class="flex gap-2"
                >
                    <input
                        type="text"
                        name="q"
                        value="{{ $query }}"
                        placeholder="Search hotels, events, activities..."
                        class="flex-1 rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    />
                    <button type="submit" class="btn-primary">Search</button>
                </form>
            </div>
        </div>

        <!-- Results Summary -->
        <div class="text-center">
            <p class="text-gray-600">
                Found
                {{ ($hotels->count() ?? 0) + ($beachEvents->count() ?? 0) + ($parkActivities->count() ?? 0) }}
                result{{ ($hotels->count() ?? 0) + ($beachEvents->count() ?? 0) + ($parkActivities->count() ?? 0) != 1 ? "s" : "" }}
            </p>
        </div>

        <!-- Hotels Results -->
        @if (isset($hotels) && $hotels->count() > 0)
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Hotels ({{ $hotels->count() }})
                    </h2>
                    <a
                        href="{{ route("hotels.browse") }}"
                        class="text-sm btn-secondary"
                    >
                        View All Hotels
                    </a>
                </div>

                <div
                    class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6"
                >
                    @foreach ($hotels as $hotel)
                        <article
                            class="card overflow-hidden hover:shadow-lg transition-shadow duration-300"
                        >
                            <div class="relative">
                                <img
                                    src="{{ $hotel->image_url }}"
                                    alt="{{ $hotel->name }}"
                                    class="h-48 w-full object-cover"
                                />
                                @if ($hotel->rating)
                                    <div
                                        class="absolute top-3 right-3 bg-white rounded-full px-3 py-1 shadow-md"
                                    >
                                        <div class="flex items-center gap-1">
                                            <svg
                                                class="w-4 h-4 text-yellow-400 fill-current"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                                />
                                            </svg>
                                            <span
                                                class="text-sm font-semibold text-gray-900"
                                            >
                                                {{ $hotel->rating }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2"
                                >
                                    {{ $hotel->name }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-2">
                                    {{ $hotel->address }}
                                </p>
                                @if ($hotel->description)
                                    <p
                                        class="text-gray-600 text-sm line-clamp-2"
                                    >
                                        {{ Str::limit($hotel->description, 100) }}
                                    </p>
                                @endif

                                <div class="mt-4 flex gap-2">
                                    <a
                                        href="{{ route("hotels.show", $hotel) }}"
                                        class="btn-primary flex-1 text-center"
                                    >
                                        View Details
                                    </a>

                                    @auth
                                        <a
                                            href="{{ route("bookings.create", ["hotel_id" => $hotel->id]) }}"
                                            class="btn-secondary flex-1 text-center"
                                        >
                                            Book Now
                                        </a>
                                    @else
                                        <a
                                            href="{{ route("login") }}"
                                            class="btn-secondary flex-1 text-center"
                                        >
                                            Login to Book
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Beach Events Results -->
        @if (isset($beachEvents) && $beachEvents->count() > 0)
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Beach Events ({{ $beachEvents->count() }})
                    </h2>
                    <a
                        href="{{ route("beach-events.index") }}"
                        class="text-sm btn-secondary"
                    >
                        View All Events
                    </a>
                </div>

                <div
                    class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6"
                >
                    @foreach ($beachEvents as $event)
                        <article
                            class="card overflow-hidden hover:shadow-lg transition-shadow duration-300"
                        >
                            <div class="relative">
                                <img
                                    src="{{ $event->image_url }}"
                                    alt="{{ $event->name }}"
                                    class="h-48 w-full object-cover"
                                />
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-600 text-white"
                                    >
                                        {{ ucfirst(str_replace("_", " ", $event->event_type)) }}
                                    </span>
                                </div>
                                @if ($event->equipment_included)
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-600 text-white"
                                        >
                                            Equipment Included
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2"
                                >
                                    {{ $event->name }}
                                </h3>
                                <div
                                    class="space-y-2 text-sm text-gray-600 mb-3"
                                >
                                    <div class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                        <span>
                                            {{ \Carbon\Carbon::parse($event->event_date)->format("M d, Y") }}
                                        </span>
                                    </div>
                                    @if ($event->location)
                                        <div class="flex items-center gap-2">
                                            <svg
                                                class="w-4 h-4 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                                />
                                            </svg>
                                            <span>{{ $event->location }}</span>
                                        </div>
                                    @endif
                                </div>
                                @if ($event->price)
                                    <div class="text-center mb-3">
                                        <span
                                            class="text-xl font-bold text-emerald-600"
                                        >
                                            ${{ number_format($event->price, 2) }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            per person
                                        </span>
                                    </div>
                                @endif

                                <div class="flex gap-2">
                                    <a
                                        href="{{ route("beach-events.show", $event) }}"
                                        class="btn-primary flex-1 text-center"
                                    >
                                        View Details
                                    </a>

                                    @auth
                                        <a
                                            href="{{ route("beach-events.book", $event) }}"
                                            class="btn-secondary flex-1 text-center"
                                        >
                                            Book Now
                                        </a>
                                    @else
                                        <a
                                            href="{{ route("login") }}"
                                            class="btn-secondary flex-1 text-center"
                                        >
                                            Login to Book
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Theme Park Activities Results -->
        @if (isset($parkActivities) && $parkActivities->count() > 0)
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Theme Park Activities ({{ $parkActivities->count() }})
                    </h2>
                    <a
                        href="{{ route("theme-park.index") }}"
                        class="text-sm btn-secondary"
                    >
                        View All Activities
                    </a>
                </div>

                <div
                    class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6"
                >
                    @foreach ($parkActivities as $activity)
                        <article
                            class="card overflow-hidden hover:shadow-lg transition-shadow duration-300"
                        >
                            <div class="relative">
                                <img
                                    src="{{ $activity->image_url }}"
                                    alt="{{ $activity->name }}"
                                    class="h-48 w-full object-cover"
                                />
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-600 text-white"
                                    >
                                        {{ ucfirst($activity->category) }}
                                    </span>
                                </div>
                                @if ($activity->price)
                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-600 text-white"
                                        >
                                            ${{ number_format($activity->price, 2) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2"
                                >
                                    {{ $activity->name }}
                                </h3>
                                @if ($activity->description)
                                    <p
                                        class="text-gray-600 text-sm line-clamp-2 mb-3"
                                    >
                                        {{ Str::limit($activity->description, 100) }}
                                    </p>
                                @endif

                                <div
                                    class="space-y-2 text-sm text-gray-600 mb-3"
                                >
                                    @if ($activity->duration_minutes)
                                        <div class="flex items-center gap-2">
                                            <svg
                                                class="w-4 h-4 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>
                                            <span>
                                                {{ $activity->duration_minutes }}
                                                minutes
                                            </span>
                                        </div>
                                    @endif

                                    @if ($activity->capacity)
                                        <div class="flex items-center gap-2">
                                            <svg
                                                class="w-4 h-4 text-gray-400"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                                />
                                            </svg>
                                            <span>
                                                Capacity:
                                                {{ $activity->capacity }}
                                                people
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <a
                                        href="{{ route("theme-park.activities.show", $activity) }}"
                                        class="btn-primary flex-1 text-center"
                                    >
                                        View Details
                                    </a>

                                    @auth
                                        @if (! auth()->user()->isAdmin() &&! auth()->user()->isParkOperator() &&! auth()->user()->isFerryOperator() &&! auth()->user()->isBeachOrganizer() &&! auth()->user()->isHotelOperator())
                                            <a
                                                href="{{ route("theme-park.book-ticket") }}"
                                                class="btn-secondary flex-1 text-center"
                                            >
                                                Book Ticket
                                            </a>
                                        @endif
                                    @else
                                        <a
                                            href="{{ route("login") }}"
                                            class="btn-secondary flex-1 text-center"
                                        >
                                            Login to Book
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- No Results -->
        @if (

            (! isset($hotels) || $hotels->count() == 0) &&
            (! isset($beachEvents) || $beachEvents->count() == 0) &&
            (! isset($parkActivities) || $parkActivities->count() == 0)        )
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <svg
                        class="mx-auto h-12 w-12 text-gray-400"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        No results found
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Try adjusting your search terms or browse our categories
                        below.
                    </p>
                </div>
            </div>
        @endif

        <!-- Browse Categories -->
        <div class="text-center py-8">
            <div class="card max-w-4xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">
                        Can't find what you're looking for?
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a
                            href="{{ route("hotels.browse") }}"
                            class="card hover:shadow-md transition-shadow duration-200"
                        >
                            <div class="card-body text-center">
                                <div class="text-3xl mb-2">
                                    <iconify-icon
                                        icon="mdi:hotel"
                                    ></iconify-icon>
                                </div>
                                <h4 class="font-semibold text-gray-900">
                                    Browse Hotels
                                </h4>
                                <p class="text-sm text-gray-600">
                                    Find your perfect accommodation
                                </p>
                            </div>
                        </a>
                        <a
                            href="{{ route("beach-events.index") }}"
                            class="card hover:shadow-md transition-shadow duration-200"
                        >
                            <div class="card-body text-center">
                                <div class="text-3xl mb-2">
                                    <iconify-icon
                                        icon="mdi:beach"
                                    ></iconify-icon>
                                </div>
                                <h4 class="font-semibold text-gray-900">
                                    Beach Events
                                </h4>
                                <p class="text-sm text-gray-600">
                                    Discover exciting activities
                                </p>
                            </div>
                        </a>
                        <a
                            href="{{ route("theme-park.index") }}"
                            class="card hover:shadow-md transition-shadow duration-200"
                        >
                            <div class="card-body text-center">
                                <div class="text-3xl mb-2">
                                    <iconify-icon
                                        icon="tabler:rollercoaster"
                                    ></iconify-icon>
                                </div>
                                <h4 class="font-semibold text-gray-900">
                                    Theme Park
                                </h4>
                                <p class="text-sm text-gray-600">
                                    Experience thrilling adventures
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
