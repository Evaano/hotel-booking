@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-900">
                Beach Events & Activities
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Experience the thrill of water sports, beach parties, and
                outdoor adventures on our pristine island beaches.
            </p>
        </div>

        <!-- Search and Filter Section -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <div></div>
                    @auth
                        @if (auth()->user()->role === "beach_organizer" || auth()->user()->role === "admin")
                            <a
                                href="{{ route("beach-events.create") }}"
                                class="btn-primary"
                            >
                                Create Event
                            </a>
                        @endif
                    @endauth
                </div>
                <form
                    method="GET"
                    action="{{ route("beach-events.index") }}"
                    class="space-y-4"
                >
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label
                                for="search"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Search Events
                            </label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request("search") }}"
                                placeholder="Event name or description..."
                                class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                            />
                        </div>
                        <div>
                            <label
                                for="event_type"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Event Type
                            </label>
                            @php($eventTypeOptions = [
                                ["label" => "All Types", "value" => ""],
                                ["label" => "Water Sports", "value" => "water_sports"],
                                ["label" => "Beach Volleyball", "value" => "beach_volleyball"],
                                ["label" => "Surfing", "value" => "surfing"],
                                ["label" => "Snorkeling", "value" => "snorkeling"],
                                ["label" => "Beach Party", "value" => "beach_party"],
                                ["label" => "Other", "value" => "other"],
                            ])
                            <select
                                id="event_type"
                                name="event_type"
                                class="form-input"
                            >
                                @foreach ($eventTypeOptions as $option)
                                    <option
                                        value="{{ $option["value"] }}"
                                        {{ request("event_type") === $option["value"] ? "selected" : "" }}
                                    >
                                        {{ $option["label"] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                for="date_range"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Date Range
                            </label>
                            @php($dateRangeOptions = [
                                ["label" => "Any Date", "value" => ""],
                                ["label" => "Today", "value" => "today"],
                                ["label" => "Tomorrow", "value" => "tomorrow"],
                                ["label" => "This Week", "value" => "this_week"],
                                ["label" => "This Month", "value" => "this_month"],
                            ])
                            <select
                                id="date_range"
                                name="date_range"
                                class="form-input"
                            >
                                @foreach ($dateRangeOptions as $option)
                                    <option
                                        value="{{ $option["value"] }}"
                                        {{ request("date_range") === $option["value"] ? "selected" : "" }}
                                    >
                                        {{ $option["label"] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                for="price_range"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Price Range
                            </label>
                            @php($priceRangeOptions = [
                                ["label" => "Any Price", "value" => ""],
                                ["label" => 'Free - $50', "value" => "0-50"],
                                ["label" => '$50 - $100', "value" => "50-100"],
                                ["label" => '$100 - $200', "value" => "100-200"],
                                ["label" => '$200+', "value" => "200+"],
                            ])
                            <select
                                id="price_range"
                                name="price_range"
                                class="form-input"
                            >
                                @foreach ($priceRangeOptions as $option)
                                    <option
                                        value="{{ $option["value"] }}"
                                        {{ request("price_range") === $option["value"] ? "selected" : "" }}
                                    >
                                        {{ $option["label"] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="btn-primary">
                            Search Events
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Count -->
        @if (isset($events) && $events->count() > 0)
            <div class="text-center">
                <p class="text-gray-600">
                    Found {{ $events->count() }}
                    event{{ $events->count() != 1 ? "s" : "" }} matching your
                    criteria
                </p>
            </div>
        @endif

        <!-- Events Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($events ?? [] as $event)
                <article
                    class="card overflow-visible hover:shadow-lg transition-shadow duration-300"
                >
                    <!-- Event Image -->
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

                    <!-- Event Details -->
                    <div class="card-body space-y-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ $event->name }}
                            </h3>
                            @if ($event->description)
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ Str::limit($event->description, 120) }}
                                </p>
                            @endif
                        </div>

                        <!-- Event Info -->
                        <div class="space-y-3">
                            <div
                                class="flex items-center gap-2 text-sm text-gray-600"
                            >
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
                                    {{ \Carbon\Carbon::parse($event->event_date)->toHumanDateFull() }}
                                </span>
                            </div>

                            <div
                                class="flex items-center gap-2 text-sm text-gray-600"
                            >
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
                                    {{ \Carbon\Carbon::parse($event->start_time)->toHumanTime() }}
                                    -
                                    {{ \Carbon\Carbon::parse($event->end_time)->toHumanTime() }}
                                </span>
                            </div>

                            @if ($event->location)
                                <div
                                    class="flex items-center gap-2 text-sm text-gray-600"
                                >
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
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    <span>{{ $event->location }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Restrictions and Capacity -->
                        <div class="flex items-center justify-between text-sm">
                            @if ($event->age_restriction)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                >
                                    Age {{ $event->age_restriction }}+
                                </span>
                            @endif

                            <span class="text-gray-600">
                                Capacity: {{ $event->capacity }} participants
                            </span>
                        </div>

                        <!-- Price -->

                        @if ($event->price)
                            <div class="text-center">
                                <span
                                    class="text-2xl font-bold text-emerald-600"
                                >
                                    ${{ number_format($event->price, 2) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    per person
                                </span>
                            </div>
                        @else
                            <div class="text-center">
                                <span
                                    class="text-lg font-semibold text-emerald-600"
                                >
                                    Free Event
                                </span>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div
                            class="flex flex-wrap gap-2 pt-2 items-center overflow-visible"
                        >
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

                            <!-- Management dropdown removed from visitor view -->
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
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
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"
                            />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            No events found
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Try adjusting your search criteria or check back
                            later for new events.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Call to Action -->
        @if (isset($events) && $events->count() > 0)
            <div class="text-center py-8">
                <div class="card max-w-2xl mx-auto">
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Want to Organize an Event?
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Join our community of event organizers and create
                            unforgettable beach experiences for our visitors.
                        </p>
                        <div class="flex gap-4 justify-center">
                            @auth
                                @if (auth()->user()->role === "beach_organizer" || auth()->user()->role === "admin")
                                    <a
                                        href="{{ route("beach-events.create") }}"
                                        class="btn-primary"
                                    >
                                        Create Event
                                    </a>
                                @else
                                    <a
                                        href="{{ route("contact") }}"
                                        class="btn-primary"
                                    >
                                        Contact Us
                                    </a>
                                @endif
                            @else
                                <a
                                    href="{{ route("register") }}"
                                    class="btn-primary"
                                >
                                    Register as Organizer
                                </a>
                            @endauth
                            <a href="{{ route("map") }}" class="btn-secondary">
                                View Beach Locations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
