@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Hotel Header -->
        <div class="space-y-4">
            <div class="flex items-center gap-4">
                <a
                    href="{{ route("hotels.browse") }}"
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
                <h1 class="text-4xl font-bold text-gray-900">
                    {{ $hotel->name }}
                </h1>
            </div>
            <p class="text-xl text-gray-600">{{ $hotel->address }}</p>
        </div>

        <!-- Hotel Image Gallery -->
        <div class="card overflow-hidden">
            <img
                src="{{ $hotel->image_url }}"
                alt="{{ $hotel->name }}"
                class="w-full h-96 object-cover"
            />
        </div>

        <!-- Hotel Information Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                @if ($hotel->description)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-gray-900">
                                About This Hotel
                            </h2>
                        </div>
                        <div class="card-body">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $hotel->description }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Amenities -->
                @php($hotelAmenities = collect($hotel->amenities ?? [])->flatten()->filter()->values()->all())
                @if (count($hotelAmenities) > 0)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Hotel Amenities
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach ($hotelAmenities as $amenity)
                                    <div class="flex items-center gap-3">
                                        <svg
                                            class="w-5 h-5 text-emerald-500"
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
                                        <span class="text-gray-700">
                                            {{ ucfirst((string) $amenity) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Available Rooms -->
                @if ($hotel->rooms && $hotel->rooms->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Available Rooms
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4">
                                @foreach ($hotel->rooms as $room)
                                    <div
                                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
                                    >
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div class="flex-1">
                                                <h3
                                                    class="text-lg font-semibold text-gray-900"
                                                >
                                                    {{ $room->room_type }}
                                                </h3>
                                                <p
                                                    class="text-gray-600 text-sm"
                                                >
                                                    {{ $room->description }}
                                                </p>
                                                <div
                                                    class="flex items-center gap-4 mt-2 text-sm text-gray-500"
                                                >
                                                    <span
                                                        class="flex items-center gap-1"
                                                    >
                                                        <svg
                                                            class="w-4 h-4"
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
                                                        Max
                                                        {{ $room->max_occupancy }}
                                                        guests
                                                    </span>
                                                    @php($roomAmenities = collect($room->amenities ?? [])->flatten()->filter()->values()->all())
                                                    @if (count($roomAmenities) > 0)
                                                        <span
                                                            class="flex items-center gap-1"
                                                        >
                                                            <svg
                                                                class="w-4 h-4"
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
                                                            {{ count($roomAmenities) }}
                                                            amenities
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div
                                                    class="text-2xl font-bold text-emerald-600"
                                                >
                                                    ${{ number_format($room->base_price, 2) }}
                                                </div>
                                                <div
                                                    class="text-sm text-gray-500"
                                                >
                                                    per night
                                                </div>
                                                <div class="mt-2">
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $room->status === "available" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}"
                                                    >
                                                        {{ ucfirst($room->status) }}
                                                    </span>
                                                </div>
                                                @auth
                                                    @if ($room->status === "available")
                                                        <a
                                                            href="{{ route("bookings.create", ["room_id" => $room->id]) }}"
                                                            class="btn-primary mt-3 inline-flex"
                                                        >
                                                            Book this room
                                                        </a>
                                                    @endif
                                                @endauth
                                            </div>
                                        </div>

                                        @if (count($roomAmenities) > 0)
                                            <div
                                                class="mt-4 pt-4 border-t border-gray-200"
                                            >
                                                <h4
                                                    class="text-sm font-medium text-gray-700 mb-2"
                                                >
                                                    Room Amenities:
                                                </h4>
                                                <div
                                                    class="flex flex-wrap gap-2"
                                                >
                                                    @foreach ($roomAmenities as $amenity)
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                                        >
                                                            {{ ucfirst((string) $amenity) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Location Information -->
                @if ($hotel->latitude && $hotel->longitude)
                    <div class="card">
                        <div class="card-header">
                            <h2 class="text-2xl font-bold text-gray-900">
                                Location
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="space-y-4">
                                <p class="text-gray-700">
                                    {{ $hotel->address }}
                                </p>
                                <div
                                    class="bg-gray-100 rounded-lg p-4 text-center"
                                >
                                    <p class="text-sm text-gray-600 mb-2">
                                        Coordinates
                                    </p>
                                    <p class="font-mono text-gray-800">
                                        {{ $hotel->latitude }},
                                        {{ $hotel->longitude }}
                                    </p>
                                </div>
                                <div class="flex gap-4">
                                    <a
                                        href="{{ route("map") }}"
                                        class="btn-secondary"
                                    >
                                        View on Map
                                    </a>
                                    <a
                                        href="https://maps.google.com/?q={{ $hotel->latitude }},{{ $hotel->longitude }}"
                                        target="_blank"
                                        class="btn-secondary"
                                    >
                                        Open in Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Info Card -->
                <div class="card">
                    <div class="card-body space-y-4">
                        @if ($hotel->rating)
                            <div class="flex items-center gap-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg
                                            class="w-5 h-5 {{ $i <= $hotel->rating ? "text-yellow-400" : "text-gray-300" }} fill-current"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                            />
                                        </svg>
                                    @endfor
                                </div>
                                <span
                                    class="text-lg font-semibold text-gray-900"
                                >
                                    {{ $hotel->rating }}/5
                                </span>
                            </div>
                        @endif

                        <div class="border-t border-gray-200 pt-4">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-2"
                            >
                                Quick Facts
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        Total Rooms:
                                    </span>
                                    <span class="font-medium text-gray-900">
                                        {{ $hotel->rooms->count() ?? 0 }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">
                                        Available Rooms:
                                    </span>
                                    <span class="font-medium text-gray-900">
                                        {{ $hotel->rooms->where("status", "available")->count() ?? 0 }}
                                    </span>
                                </div>
                                @php($hotelAmenitiesCount = count(collect($hotel->amenities ?? [])->flatten()->filter(),))
                                @if ($hotelAmenitiesCount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">
                                            Amenities:
                                        </span>
                                        <span class="font-medium text-gray-900">
                                            {{ $hotelAmenitiesCount }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h3
                                class="text-lg font-semibold text-gray-900 mb-2"
                            >
                                Starting From
                            </h3>
                            @if ($hotel->rooms->count() > 0)
                                @php($lowestPrice = $hotel->rooms->min("base_price"))
                                <div
                                    class="text-3xl font-bold text-emerald-600"
                                >
                                    ${{ number_format($lowestPrice, 2) }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    per night
                                </div>
                            @else
                                <p class="text-gray-500">Contact for pricing</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Booking Actions -->
                <div class="card">
                    <div class="card-body space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Ready to Book?
                        </h3>

                        @auth
                            <a
                                href="{{ route("bookings.create", ["hotel_id" => $hotel->id]) }}"
                                class="w-full btn-primary text-center"
                            >
                                Book This Hotel
                            </a>
                        @else
                            <a
                                href="{{ route("login") }}"
                                class="w-full btn-primary text-center"
                            >
                                Login to Book
                            </a>
                            <a
                                href="{{ route("register") }}"
                                class="w-full btn-secondary text-center"
                            >
                                Create Account
                            </a>
                        @endauth

                        <div class="text-center">
                            <p class="text-sm text-gray-600">
                                Questions about this hotel?
                            </p>
                            <a
                                href="{{ route("contact") }}"
                                class="text-primary-600 hover:text-primary-700 text-sm font-medium"
                            >
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Hotel Operator Info -->
                @if ($hotel->operator)
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Hotel Operator
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center"
                                >
                                    <span
                                        class="text-primary-600 font-semibold"
                                    >
                                        {{ substr($hotel->operator->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $hotel->operator->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $hotel->operator->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center py-8">
            <div class="card max-w-2xl mx-auto">
                <div class="card-body text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">
                        Explore More Options
                    </h3>
                    <p class="text-gray-600 mb-4">
                        Discover other amazing hotels and start planning your
                        perfect island getaway.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a
                            href="{{ route("hotels.browse") }}"
                            class="btn-primary"
                        >
                            Browse All Hotels
                        </a>
                        <a href="{{ route("map") }}" class="btn-secondary">
                            View Island Map
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
