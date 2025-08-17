@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-900">
                Ferry Schedules & Routes
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Plan your island adventure with our comprehensive ferry service
                connecting mainland to paradise.
            </p>
        </div>

        <!-- Quick Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-primary-600">
                        {{ $schedules->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Active Routes</div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-emerald-600">
                        {{ $schedules->sum("capacity") ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">
                        Total Daily Capacity
                    </div>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $schedules->where("status", "active")->count() ?? 0 }}
                    </div>
                    <div class="text-sm text-gray-600">Operating Today</div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="card">
            <div class="card-body">
                <div class="flex items-center justify-between mb-4">
                    <div></div>
                    @auth
                        @if (auth()->user()->role === "ferry_operator" || auth()->user()->role === "admin")
                            <a
                                href="{{ route("ferry.create-schedule") }}"
                                class="btn-primary"
                            >
                                Create Schedule
                            </a>
                        @endif
                    @endauth
                </div>
                <form
                    method="GET"
                    action="{{ route("ferry.schedules") }}"
                    class="space-y-4"
                >
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label
                                for="route"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Route
                            </label>
                            <select id="route" name="route" class="form-input">
                                <option value="">All Routes</option>
                                @foreach ($schedules->pluck("route")->unique() as $route)
                                    <option
                                        value="{{ $route }}"
                                        {{ request("route") == $route ? "selected" : "" }}
                                    >
                                        {{ $route }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                for="day"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Day of Week
                            </label>
                            <select id="day" name="day" class="form-input">
                                <option value="">Any Day</option>
                                <option
                                    value="monday"
                                    {{ request("day") == "monday" ? "selected" : "" }}
                                >
                                    Monday
                                </option>
                                <option
                                    value="tuesday"
                                    {{ request("day") == "tuesday" ? "selected" : "" }}
                                >
                                    Tuesday
                                </option>
                                <option
                                    value="wednesday"
                                    {{ request("day") == "wednesday" ? "selected" : "" }}
                                >
                                    Wednesday
                                </option>
                                <option
                                    value="thursday"
                                    {{ request("day") == "thursday" ? "selected" : "" }}
                                >
                                    Thursday
                                </option>
                                <option
                                    value="friday"
                                    {{ request("day") == "friday" ? "selected" : "" }}
                                >
                                    Friday
                                </option>
                                <option
                                    value="saturday"
                                    {{ request("day") == "saturday" ? "selected" : "" }}
                                >
                                    Saturday
                                </option>
                                <option
                                    value="sunday"
                                    {{ request("day") == "sunday" ? "selected" : "" }}
                                >
                                    Sunday
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                for="status"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Status
                            </label>
                            <select
                                id="status"
                                name="status"
                                class="form-input"
                            >
                                <option value="">All Status</option>
                                <option
                                    value="active"
                                    {{ request("status") == "active" ? "selected" : "" }}
                                >
                                    Active
                                </option>
                                <option
                                    value="inactive"
                                    {{ request("status") == "inactive" ? "selected" : "" }}
                                >
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class="btn-primary">
                            Filter Schedules
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Count -->
        @if (isset($schedules) && $schedules->count() > 0)
            <div class="text-center">
                <p class="text-gray-600">
                    Found {{ $schedules->count() }}
                    schedule{{ $schedules->count() != 1 ? "s" : "" }} matching
                    your criteria
                </p>
            </div>
        @endif

        <!-- Schedules Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Route
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Schedule
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Days
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Capacity
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Price
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($schedules ?? [] as $schedule)
                        <tr class="hover:bg-gray-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ $schedule->route }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->toHumanTime() }}
                                →
                                {{ \Carbon\Carbon::parse($schedule->arrival_time)->toHumanTime() }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                @if ($schedule->days_of_week && is_array($schedule->days_of_week) && count($schedule->days_of_week) > 0)
                                    {{ collect($schedule->days_of_week)->map(fn ($d) => ucfirst(substr($d, 0, 3)))->join(", ") }}
                                @else
                                    —
                                @endif
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ number_format($schedule->capacity) }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ $schedule->price ? '$' . number_format($schedule->price, 2) : "Free" }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $schedule->status === "active" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}"
                                >
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm"
                            >
                                <div class="inline-flex gap-3">
                                    @auth
                                        @if (auth()->user()->role === "visitor")
                                            <a
                                                href="{{ route("ferry.book-ticket", ["schedule_id" => $schedule->id]) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-200 {{ $schedule->status !== "active" ? "opacity-50 pointer-events-none" : "" }}"
                                                title="Book Ticket"
                                                aria-label="Book Ticket"
                                            >
                                                <iconify-icon
                                                    icon="tabler:ticket"
                                                    width="20"
                                                    height="20"
                                                    aria-hidden="true"
                                                ></iconify-icon>
                                                <span class="sr-only">
                                                    Book Ticket
                                                </span>
                                            </a>
                                        @endif

                                        @if (auth()->user()->role === "ferry_operator" || auth()->user()->role === "admin")
                                            <a
                                                href="{{ route("ferry.edit-schedule", $schedule) }}"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                                                title="Edit"
                                                aria-label="Edit"
                                            >
                                                <iconify-icon
                                                    icon="tabler:pencil"
                                                    width="20"
                                                    height="20"
                                                    aria-hidden="true"
                                                ></iconify-icon>
                                                <span class="sr-only">
                                                    Edit
                                                </span>
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route("ferry.delete-schedule", $schedule) }}"
                                                class="inline"
                                                onsubmit="return confirm('Delete this schedule?');"
                                            >
                                                @csrf
                                                @method("DELETE")
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-200"
                                                    title="Delete"
                                                    aria-label="Delete"
                                                >
                                                    <iconify-icon
                                                        icon="tabler:trash"
                                                        width="20"
                                                        height="20"
                                                        aria-hidden="true"
                                                    ></iconify-icon>
                                                    <span class="sr-only">
                                                        Delete
                                                    </span>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a
                                            href="{{ route("login") }}"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-full text-blue-600 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                            title="Login to Book"
                                            aria-label="Login to Book"
                                        >
                                            <iconify-icon
                                                icon="tabler:lock"
                                                width="20"
                                                height="20"
                                                aria-hidden="true"
                                            ></iconify-icon>
                                            <span class="sr-only">
                                                Login to Book
                                            </span>
                                        </a>
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="7"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No schedules found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Important Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Booking Requirements
                    </h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex-shrink-0 w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center"
                        >
                            <span class="text-primary-600 text-xs font-bold">
                                1
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Hotel Booking Required
                            </p>
                            <p class="text-sm text-gray-600">
                                You must have a confirmed hotel reservation
                                before booking ferry tickets.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div
                            class="flex-shrink-0 w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center"
                        >
                            <span class="text-primary-600 text-xs font-bold">
                                2
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Valid ID Required
                            </p>
                            <p class="text-sm text-gray-600">
                                Please bring a valid government-issued ID for
                                boarding.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div
                            class="flex-shrink-0 w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center"
                        >
                            <span class="text-primary-600 text-xs font-bold">
                                3
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Arrive Early
                            </p>
                            <p class="text-sm text-gray-600">
                                Please arrive at least 30 minutes before
                                departure time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Travel Tips
                    </h3>
                </div>
                <div class="card-body space-y-3">
                    <div class="flex items-start gap-3">
                        <svg
                            class="w-5 h-5 text-emerald-500 mt-0.5"
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
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Weather Updates
                            </p>
                            <p class="text-sm text-gray-600">
                                Check weather conditions before departure as
                                schedules may be affected.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg
                            class="w-5 h-5 text-emerald-500 mt-0.5"
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
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Luggage Policy
                            </p>
                            <p class="text-sm text-gray-600">
                                Each passenger is allowed one carry-on bag and
                                one checked bag.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg
                            class="w-5 h-5 text-emerald-500 mt-0.5"
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
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                Pet Policy
                            </p>
                            <p class="text-sm text-gray-600">
                                Small pets are welcome but must be in carriers
                                and pre-registered.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Ready to Book Your Ferry?
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Secure your spot on our next available ferry and start
                        your island adventure!
                    </p>
                    <div class="flex gap-4 justify-center">
                        @auth
                            <a
                                href="{{ route("ferry.book-ticket") }}"
                                class="btn-primary"
                            >
                                Book
                                Ferry
                                Ticket
                            </a>
                        @else
                            <a
                                href="{{ route("register") }}"
                                class="btn-primary"
                            >
                                Register
                                Now
                            </a>
                        @endauth
                        <a
                            href="{{ route("hotels.browse") }}"
                            class="btn-secondary"
                        >
                            Find Hotels
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
