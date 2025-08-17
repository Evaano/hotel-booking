@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-12">
        @if ($advertisements->count() > 0)
            <section class="space-y-6">
                <div class="text-center">
                    <h1 class="text-3xl font-semibold text-muted-900">
                        Welcome to Our Theme Park
                    </h1>
                    <p class="mt-2 text-muted-600">
                        Discover amazing attractions, comfortable hotels,
                        exciting events, and unforgettable experiences!
                    </p>
                </div>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    @foreach ($advertisements as $ad)
                        <article class="card overflow-hidden">
                            <img
                                src="{{ $ad->image_url }}"
                                alt="{{ $ad->title }}"
                                class="h-48 w-full object-cover"
                                onerror="this.onerror=null;this.src='https://picsum.photos/seed/ad-{{ $ad->id ?? Str::slug($ad->title) }}-fallback/800/400';"
                            />
                            <div class="card-body">
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    {{ $ad->title }}
                                </h3>
                                <p class="mt-1 text-muted-600">
                                    {{ $ad->description }}
                                </p>
                                @if ($ad->link_url)
                                    <div class="mt-4">
                                        <a
                                            href="{{ $ad->link_url }}"
                                            class="btn-primary"
                                        >
                                            Learn More
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($featuredHotels->count() > 0)
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-muted-900">
                        Featured Hotels
                    </h2>
                    <a
                        href="{{ route("hotels.browse") }}"
                        class="text-sm btn-secondary"
                    >
                        View all
                    </a>
                </div>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    @foreach ($featuredHotels as $hotel)
                        <article class="card overflow-hidden h-full">
                            <img
                                src="{{ $hotel->image_url }}"
                                alt="{{ $hotel->name }}"
                                class="h-48 w-full object-cover"
                            />
                            <div class="card-body">
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    {{ $hotel->name }}
                                </h3>
                                <p class="mt-1 text-muted-600">
                                    {{ Str::limit($hotel->description, 100) }}
                                </p>
                                <p class="mt-2 text-sm text-muted-500">
                                    {{ $hotel->address }}
                                </p>
                                @if ($hotel->price_per_night)
                                    <p
                                        class="mt-2 font-semibold text-emerald-600"
                                    >
                                        ${{ number_format($hotel->price_per_night, 2) }}
                                        per night
                                    </p>
                                @endif

                                <div class="mt-4">
                                    <a
                                        href="{{ route("hotels.show", $hotel) }}"
                                        class="btn-primary"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($upcomingEvents->count() > 0)
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-muted-900">
                        Upcoming Beach Events
                    </h2>
                    <a
                        href="{{ route("beach-events.index") }}"
                        class="text-sm btn-secondary"
                    >
                        View all
                    </a>
                </div>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
                >
                    @foreach ($upcomingEvents as $event)
                        <article class="card p-6">
                            <h3 class="text-lg font-semibold text-muted-900">
                                {{ $event->name }}
                            </h3>
                            <p class="mt-1 text-muted-600">
                                {{ Str::limit($event->description, 80) }}
                            </p>
                            <p class="mt-2 text-sm text-muted-500">
                                {{ \Carbon\Carbon::parse($event->event_date)->format("M d, Y") }}
                            </p>
                            <p class="text-sm text-muted-500">
                                {{ $event->location }}
                            </p>
                            @if ($event->price)
                                <p class="mt-2 font-semibold text-emerald-600">
                                    ${{ number_format($event->price, 2) }}
                                </p>
                            @endif

                            <div class="mt-4">
                                <a
                                    href="{{ route("beach-events.show", $event) }}"
                                    class="btn-primary"
                                >
                                    Learn More
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($popularActivities->count() > 0)
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-semibold text-muted-900">
                        Popular Activities
                    </h2>
                    <a
                        href="{{ route("theme-park.index") }}"
                        class="text-sm btn-secondary"
                    >
                        View all
                    </a>
                </div>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                >
                    @foreach ($popularActivities as $activity)
                        <article class="card overflow-hidden h-full">
                            <img
                                src="{{ $activity->image_url }}"
                                alt="{{ $activity->name }}"
                                class="h-48 w-full object-cover"
                            />
                            <div class="card-body">
                                <h3
                                    class="text-lg font-semibold text-muted-900"
                                >
                                    {{ $activity->name }}
                                </h3>
                                <p class="mt-1 text-muted-600">
                                    {{ Str::limit($activity->description, 100) }}
                                </p>
                                @if ($activity->duration)
                                    <p class="mt-2 text-sm text-muted-500">
                                        Duration: {{ $activity->duration }}
                                        minutes
                                    </p>
                                @endif

                                @if ($activity->price)
                                    <p
                                        class="mt-2 font-semibold text-emerald-600"
                                    >
                                        ${{ number_format($activity->price, 2) }}
                                    </p>
                                @endif

                                <div class="mt-4">
                                    <a
                                        href="{{ route("theme-park.activities.show", $activity) }}"
                                        class="btn-primary"
                                    >
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($locations->count() > 0)
            <section class="space-y-4">
                <h2 class="text-2xl font-semibold text-muted-900">
                    Explore Our Island
                </h2>
                <div class="card">
                    <div class="card-body text-center">
                        <p class="text-muted-600">
                            Discover all the amazing locations across our
                            beautiful island paradise.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route("map") }}" class="btn-primary">
                                View Interactive Map
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="space-y-4">
            <div class="card">
                <div class="card-body">
                    <h3
                        class="text-xl font-semibold text-muted-900 text-center"
                    >
                        Looking for something specific?
                    </h3>
                    <form
                        action="{{ route("search") }}"
                        method="GET"
                        class="mt-4 mx-auto max-w-xl flex gap-2"
                    >
                        <input
                            type="text"
                            name="q"
                            value="{{ request("q") }}"
                            placeholder="Search hotels, events, activities..."
                            class="form-input"
                        />
                        <button type="submit" class="btn-primary">
                            Search
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
