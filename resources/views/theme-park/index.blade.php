@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-900">
                Theme Park Adventures
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Experience thrilling rides, spectacular shows, and unforgettable
                adventures in our world-class theme park.
            </p>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-primary-600">
                        {{ $groupedActivities->flatten()->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Total Activities</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-emerald-600">
                        {{ $groupedActivities->get("ride", collect())->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Thrilling Rides</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $groupedActivities->get("show", collect())->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Live Shows</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-orange-600">
                        {{ $groupedActivities->get("experience", collect())->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Unique Experiences</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card">
            <div class="card-body">
                <form
                    method="GET"
                    action="{{ route("theme-park.index") }}"
                    class="space-y-4"
                >
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label
                                for="search"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Search Activities
                            </label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request("search") }}"
                                placeholder="Activity name or description..."
                                class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                            />
                        </div>
                        <div>
                            <label
                                for="category"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Category
                            </label>
                            <select
                                name="category"
                                id="category"
                                class="form-input"
                            >
                                <option
                                    value=""
                                    {{ request("category") == "" ? "selected" : "" }}
                                >
                                    All Categories
                                </option>
                                <option
                                    value="ride"
                                    {{ request("category") == "ride" ? "selected" : "" }}
                                >
                                    Rides
                                </option>
                                <option
                                    value="show"
                                    {{ request("category") == "show" ? "selected" : "" }}
                                >
                                    Shows
                                </option>
                                <option
                                    value="experience"
                                    {{ request("category") == "experience" ? "selected" : "" }}
                                >
                                    Experiences
                                </option>
                                <option
                                    value="dining"
                                    {{ request("category") == "dining" ? "selected" : "" }}
                                >
                                    Dining
                                </option>
                                <option
                                    value="shopping"
                                    {{ request("category") == "shopping" ? "selected" : "" }}
                                >
                                    Shopping
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                for="price_range"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Price Range
                            </label>
                            <select
                                name="price_range"
                                id="price_range"
                                class="form-input"
                            >
                                <option
                                    value=""
                                    {{ request("price_range") == "" ? "selected" : "" }}
                                >
                                    Any Price
                                </option>
                                <option
                                    value="0-25"
                                    {{ request("price_range") == "0-25" ? "selected" : "" }}
                                >
                                    Free - $25
                                </option>
                                <option
                                    value="25-50"
                                    {{ request("price_range") == "25-50" ? "selected" : "" }}
                                >
                                    $25 - $50
                                </option>
                                <option
                                    value="50-100"
                                    {{ request("price_range") == "50-100" ? "selected" : "" }}
                                >
                                    $50 - $100
                                </option>
                                <option
                                    value="100+"
                                    {{ request("price_range") == "100+" ? "selected" : "" }}
                                >
                                    $100+
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <x-primary-button type="submit">
                            {{ __("Search Activities") }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Category Navigation -->
        <div class="flex flex-wrap justify-center gap-2">
            @php($categoryLabels = [
                "ride" => [
                    "label" => "Rides",
                    "icon" => "tabler:rollercoaster",
                    "color" => "bg-red-100 text-red-800",
                ],
                "show" => [
                    "label" => "Shows",
                    "icon" => "mdi:drama-masks",
                    "color" => "bg-purple-100 text-purple-800",
                ],
                "experience" => [
                    "label" => "Experiences",
                    "icon" => "mdi:sparkles",
                    "color" => "bg-yellow-100 text-yellow-800",
                ],
                "dining" => [
                    "label" => "Dining",
                    "icon" => "mdi:silverware-fork-knife",
                    "color" => "bg-green-100 text-green-800",
                ],
                "shopping" => [
                    "label" => "Shopping",
                    "icon" => "tabler:shopping-bag",
                    "color" => "bg-blue-100 text-blue-800",
                ],
            ])
            @foreach ($groupedActivities ?? [] as $group => $activities)
                @php($meta = $categoryLabels[$group] ?? [
                    "label" => \Illuminate\Support\Str::title(str_replace("_", " ", $group)),
                    "icon" => "mdi:bullseye",
                    "color" => "bg-gray-100 text-gray-800",
                ])
                <button
                    onclick="scrollToCategory('{{ $group }}')"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full {{ $meta["color"] }} hover:opacity-80 transition-opacity"
                >
                    <iconify-icon
                        icon="{{ $meta["icon"] }}"
                        class="text-lg"
                    ></iconify-icon>
                    <span class="font-medium">{{ $meta["label"] }}</span>
                    <span
                        class="bg-white bg-opacity-50 rounded-full px-2 py-0.5 text-xs font-bold"
                    >
                        {{ $activities->count() }}
                    </span>
                </button>
            @endforeach
        </div>

        <!-- Activities by Category -->
        @foreach ($groupedActivities ?? [] as $group => $activities)
            @php($meta = $categoryLabels[$group] ?? [
                "label" => \Illuminate\Support\Str::title(str_replace("_", " ", $group)),
                "icon" => "mdi:bullseye",
                "color" => "bg-gray-100 text-gray-800",
            ])
            <section id="{{ $group }}" class="space-y-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        <iconify-icon
                            icon="{{ $meta["icon"] }}"
                            class="text-2xl align-middle mr-2"
                        ></iconify-icon>
                        {{ $meta["label"] }}
                    </h2>
                    <p class="text-gray-600">
                        Discover our amazing {{ strtolower($meta["label"]) }}
                        and create unforgettable memories
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 overflow-visible"
                >
                    @foreach ($activities as $activity)
                        <article
                            class="card overflow-visible hover:shadow-lg transition-shadow duration-300"
                        >
                            <!-- Activity Image -->
                            <div class="relative">
                                <img
                                    src="{{ $activity->image_url }}"
                                    alt="{{ $activity->name }}"
                                    class="h-48 w-full object-cover"
                                />
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $meta["color"] }}"
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

                            <!-- Activity Details -->
                            <div class="card-body space-y-4">
                                <div>
                                    <h3
                                        class="text-xl font-bold text-gray-900 mb-2"
                                    >
                                        {{ $activity->name }}
                                    </h3>
                                    @if ($activity->description)
                                        <p
                                            class="text-gray-600 text-sm line-clamp-2"
                                        >
                                            {{ Str::limit($activity->description, 120) }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Activity Info -->
                                <div class="space-y-3">
                                    @if ($activity->duration_minutes)
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
                                                {{ $activity->duration_minutes }}
                                                minutes
                                            </span>
                                        </div>
                                    @endif

                                    @if ($activity->capacity)
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

                                <!-- Restrictions -->
                                <div class="flex flex-wrap gap-2">
                                    @if ($activity->age_restriction)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"
                                        >
                                            Age
                                            {{ $activity->age_restriction }}+
                                        </span>
                                    @endif

                                    @if ($activity->height_restriction)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                        >
                                            Min Height:
                                            {{ $activity->height_restriction }}cm
                                        </span>
                                    @endif
                                </div>

                                <!-- Action Buttons -->
                                <div
                                    class="flex gap-2 pt-2 items-center overflow-visible"
                                >
                                    <a
                                        href="{{ route("theme-park.activities.show", $activity) }}"
                                        class="btn-primary flex-1 text-center"
                                    >
                                        View Details
                                    </a>

                                    @auth
                                        @if (! auth()->user()->isAdmin() &&! auth()->user()->isParkOperator())
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

                                    <!-- Management dropdown removed from visitor view -->
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach

        <!-- Call to Action -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-muted-900 mb-2">
                        Ready for an Adventure?
                    </h3>
                    <p class="text-muted-600 mb-4">
                        Book your theme park tickets and start planning your
                        perfect day of fun and excitement!
                    </p>
                    <div class="flex gap-4 justify-center">
                        @auth
                            @if (! auth()->user()->isAdmin() &&! auth()->user()->isParkOperator())
                                <a
                                    href="{{ route("theme-park.book-ticket") }}"
                                    class="btn-primary"
                                >
                                    Book Tickets
                                </a>
                            @endif
                        @else
                            <a
                                href="{{ route("register") }}"
                                class="btn-primary"
                            >
                                Register Now
                            </a>
                        @endauth
                        <a href="{{ route("map") }}" class="btn-secondary">
                            View Park Map
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function scrollToCategory(categoryId) {
            const element = document.getElementById(categoryId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>
@endsection
