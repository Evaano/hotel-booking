@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Event Header -->
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <a
                    href="{{ route("beach-events.index") }}"
                    class="text-primary-600 hover:text-primary-700"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                </a>
                <h1 class="text-4xl font-bold text-muted-900">
                    {{ $event->name }}
                </h1>
            </div>
            <div class="flex items-center gap-4 text-muted-600">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800"
                >
                    {{ ucfirst(str_replace("_", " ", $event->event_type)) }}
                </span>
                @if ($event->equipment_included)
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800"
                    >
                        Equipment Included
                    </span>
                @endif
            </div>
        </div>

        <!-- Event Image -->
        <div class="card overflow-hidden">
            <img
                src="{{ $event->image_url }}"
                alt="{{ $event->name }}"
                class="w-full h-96 object-cover"
            />
        </div>

        <!-- Event Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if ($event->description)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-muted-900">
                                About This Event
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="text-muted-700 leading-relaxed">
                                {{ $event->description }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Event Details -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold text-muted-900">
                            Event Details
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-primary-600"
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
                                    </div>
                                    <div>
                                        <p class="text-sm text-muted-500">
                                            Event Date
                                        </p>
                                        <p class="font-medium text-muted-900">
                                            {{ \Carbon\Carbon::parse($event->event_date)->toHumanDateFull() }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-primary-600"
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
                                    </div>
                                    <div>
                                        <p class="text-sm text-muted-500">
                                            Time
                                        </p>
                                        <p class="font-medium text-muted-900">
                                            {{ \Carbon\Carbon::parse($event->start_time)->toHumanTime() }}
                                            -
                                            {{ \Carbon\Carbon::parse($event->end_time)->toHumanTime() }}
                                        </p>
                                    </div>
                                </div>

                                @if ($event->location)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-primary-600"
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
                                        </div>
                                        <div>
                                            <p class="text-sm text-muted-500">
                                                Location
                                            </p>
                                            <p
                                                class="font-medium text-muted-900"
                                            >
                                                {{ $event->location }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-5 h-5 text-emerald-600"
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
                                    </div>
                                    <div>
                                        <p class="text-sm text-muted-500">
                                            Capacity
                                        </p>
                                        <p class="font-medium text-muted-900">
                                            {{ number_format($event->capacity) }}
                                            participants
                                        </p>
                                    </div>
                                </div>

                                @if ($event->age_restriction)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-yellow-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-muted-500">
                                                Age Requirement
                                            </p>
                                            <p
                                                class="font-medium text-muted-900"
                                            >
                                                {{ $event->age_restriction }}+
                                                years old
                                            </p>
                                        </div>
                                    </div>
                                @endif

                                @if ($event->equipment_included)
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center"
                                        >
                                            <svg
                                                class="w-5 h-5 text-blue-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                                                />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm text-muted-500">
                                                Equipment
                                            </p>
                                            <p
                                                class="font-medium text-muted-900"
                                            >
                                                All equipment provided
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Event Organizer -->
                @if ($event->organizer)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-muted-900">
                                Event Organizer
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center"
                                >
                                    <span
                                        class="text-primary-600 text-xl font-bold"
                                    >
                                        {{ substr($event->organizer->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <h3
                                        class="text-lg font-semibold text-muted-900"
                                    >
                                        {{ $event->organizer->name }}
                                    </h3>
                                    <p class="text-muted-600">
                                        {{ $event->organizer->email }}
                                    </p>
                                    <p class="text-sm text-muted-500">
                                        Professional event organizer
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- What to Bring -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-2xl font-bold text-muted-900">
                            What to Bring
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <h3 class="font-semibold text-muted-900">
                                    Essential Items:
                                </h3>
                                <ul class="space-y-2 text-muted-600">
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Comfortable beach attire
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Sunscreen (SPF 30+)
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Hat and sunglasses
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-emerald-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>
                                        Water bottle
                                    </li>
                                </ul>
                            </div>
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-900">
                                    Optional Items:
                                </h3>
                                <ul class="space-y-2 text-gray-600">
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                            />
                                        </svg>
                                        Camera for memories
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                            />
                                        </svg>
                                        Beach towel
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <svg
                                            class="w-4 h-4 text-blue-500"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                                            />
                                        </svg>
                                        Change of clothes
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Pricing Card -->
                <div class="card">
                    <div class="card-body text-center">
                        @if ($event->price)
                            <div
                                class="text-4xl font-bold text-emerald-600 mb-2"
                            >
                                ${{ number_format($event->price, 2) }}
                            </div>
                            <div class="text-muted-500 mb-4">per person</div>
                        @else
                            <div
                                class="text-3xl font-bold text-emerald-600 mb-2"
                            >
                                Free Event
                            </div>
                            <div class="text-muted-500 mb-4">
                                No cost to participate
                            </div>
                        @endif

                        <div class="space-y-3 text-sm text-muted-600 mb-6">
                            <div class="flex justify-between">
                                <span>Available Spots:</span>
                                <span class="font-medium">
                                    {{ $availableSpots ?? $event->capacity }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Event Type:</span>
                                <span class="font-medium">
                                    {{ ucfirst(str_replace("_", " ", $event->event_type)) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Duration:</span>
                                <span class="font-medium">
                                    @php
                                        $start = \Carbon\Carbon::parse($event->start_time);
                                        $end = \Carbon\Carbon::parse($event->end_time);
                                        $totalMinutes = $start->diffInMinutes($end);
                                        $hours = intval($totalMinutes / 60);
                                        $minutes = $totalMinutes % 60;
                                    @endphp
                                    @if($hours > 0 && $minutes > 0)
                                        {{ $hours }} hours {{ $minutes }} minutes
                                    @elseif($hours > 0)
                                        {{ $hours }} {{ $hours == 1 ? 'hour' : 'hours' }}
                                    @else
                                        {{ $minutes }} minutes
                                    @endif
                                </span>
                            </div>
                        </div>

                        @if (isset($userBooking) && $userBooking)
                            <div
                                class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-4"
                            >
                                <div
                                    class="flex items-center gap-2 text-emerald-800"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <span class="font-medium">
                                        You're booked for this event!
                                    </span>
                                </div>
                                <a
                                    href="{{ route("beach-events.show-booking", $userBooking) }}"
                                    class="text-emerald-700 hover:text-emerald-800 text-sm font-medium"
                                >
                                    View booking details
                                </a>
                            </div>
                        @else
                            @auth
                                <a
                                    href="{{ route("beach-events.book", $event) }}"
                                    class="w-full btn-primary mb-3"
                                >
                                    Book This Event
                                </a>
                            @else
                                <a
                                    href="{{ route("login") }}"
                                    class="w-full btn-primary mb-3"
                                >
                                    Login to Book
                                </a>
                                <a
                                    href="{{ route("register") }}"
                                    class="w-full btn-secondary"
                                >
                                    Create Account
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Event Status -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-muted-900">
                            Event Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-600">
                                    Status:
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->status === "active" ? "bg-success-100 text-success-800" : "bg-error-100 text-error-800" }}"
                                >
                                    {{ ucfirst($event->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-600">
                                    Days Until Event:
                                </span>
                                <span class="font-medium text-muted-900">
                                    @php
                                        $eventDate = \Carbon\Carbon::parse($event->event_date);
                                        $now = now();
                                        $diffInDays = $eventDate->diffInDays($now);
                                        
                                        if ($eventDate->isToday()) {
                                            echo 'Today';
                                        } elseif ($eventDate->isTomorrow()) {
                                            echo 'Tomorrow';
                                        } elseif ($eventDate->isPast()) {
                                            echo 'Event passed';
                                        } else {
                                            echo $diffInDays . ' ' . ($diffInDays == 1 ? 'day' : 'days');
                                        }
                                    @endphp
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Support -->
                <div class="card">
                    <div class="card-body text-center">
                        <h3 class="text-lg font-semibold text-muted-900 mb-2">
                            Need Help?
                        </h3>
                        <p class="text-sm text-muted-600 mb-4">
                            Questions about this event?
                        </p>
                        <a
                            href="{{ route("contact") }}"
                            class="btn-secondary w-full"
                        >
                            Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-muted-900 mb-2">
                        Discover More Events
                    </h3>
                    <p class="text-muted-600 mb-4">
                        Explore our full calendar of beach events and
                        activities!
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a
                            href="{{ route("beach-events.index") }}"
                            class="btn-primary"
                        >
                            Browse All Events
                        </a>
                        <a href="{{ route("map") }}" class="btn-secondary">
                            View Beach Locations
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
