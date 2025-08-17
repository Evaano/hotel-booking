@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <h1 class="text-4xl font-bold text-gray-900">
                Find Your Perfect Stay
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover our selection of premium hotels across the island, each
                offering unique experiences and world-class amenities.
            </p>
        </div>

        <!-- Search and Filter Section -->
        <div class="card">
            <div class="card-body">
                <form
                    method="GET"
                    action="{{ route("hotels.browse") }}"
                    class="space-y-4"
                >
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label
                                for="search"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Search Hotels
                            </label>
                            <input
                                type="text"
                                name="search"
                                id="search"
                                value="{{ request("search") }}"
                                placeholder="Hotel name, location, or amenities..."
                                class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                            />
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
                                    value="0-100"
                                    {{ request("price_range") == "0-100" ? "selected" : "" }}
                                >
                                    $0 - $100
                                </option>
                                <option
                                    value="100-200"
                                    {{ request("price_range") == "100-200" ? "selected" : "" }}
                                >
                                    $100 - $200
                                </option>
                                <option
                                    value="200-300"
                                    {{ request("price_range") == "200-300" ? "selected" : "" }}
                                >
                                    $200 - $300
                                </option>
                                <option
                                    value="300+"
                                    {{ request("price_range") == "300+" ? "selected" : "" }}
                                >
                                    $300+
                                </option>
                            </select>
                        </div>
                        <div>
                            <label
                                for="amenities"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Amenities
                            </label>
                            <select
                                name="amenities"
                                id="amenities"
                                class="form-input"
                            >
                                <option
                                    value=""
                                    {{ request("amenities") == "" ? "selected" : "" }}
                                >
                                    Any Amenities
                                </option>
                                <option
                                    value="pool"
                                    {{ request("amenities") == "pool" ? "selected" : "" }}
                                >
                                    Swimming Pool
                                </option>
                                <option
                                    value="spa"
                                    {{ request("amenities") == "spa" ? "selected" : "" }}
                                >
                                    Spa
                                </option>
                                <option
                                    value="restaurant"
                                    {{ request("amenities") == "restaurant" ? "selected" : "" }}
                                >
                                    Restaurant
                                </option>
                                <option
                                    value="gym"
                                    {{ request("amenities") == "gym" ? "selected" : "" }}
                                >
                                    Fitness Center
                                </option>
                                <option
                                    value="beach_access"
                                    {{ request("amenities") == "beach_access" ? "selected" : "" }}
                                >
                                    Beach Access
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <x-primary-button type="submit">
                            {{ __("Search Hotels") }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Count -->
        @if (isset($hotels))
            <div class="text-center">
                @if ($hotels->count() > 0)
                    <p class="text-gray-600">
                        Found {{ $hotels->count() }}
                        hotel{{ $hotels->count() != 1 ? "s" : "" }} matching
                        your criteria
                    </p>
                @else
                    <p class="text-gray-600">
                        No hotels matched your filters. Try broadening your
                        search.
                    </p>
                @endif
            </div>
        @endif

        <!-- Hotels Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($hotels ?? [] as $hotel)
                <article
                    class="card overflow-hidden hover:shadow-lg transition-shadow duration-300"
                >
                    <!-- Hotel Image -->
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

                    <!-- Hotel Details -->
                    <div class="card-body space-y-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">
                                {{ $hotel->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-2">
                                {{ $hotel->address }}
                            </p>
                            @if ($hotel->description)
                                <p class="text-gray-600 text-sm line-clamp-2">
                                    {{ Str::limit($hotel->description, 120) }}
                                </p>
                            @endif
                        </div>

                        <!-- Amenities -->
                        @php($cardAmenities = collect($hotel->amenities ?? [])->flatten()->filter()->values())
                        @if ($cardAmenities->count() > 0)
                            <div class="space-y-2">
                                <h4 class="text-sm font-semibold text-gray-700">
                                    Amenities
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($cardAmenities->take(4) as $amenity)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800"
                                        >
                                            {{ ucfirst((string) $amenity) }}
                                        </span>
                                    @endforeach

                                    @if ($cardAmenities->count() > 4)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800"
                                        >
                                            +{{ $cardAmenities->count() - 4 }}
                                            more
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Room Information -->
                        @if ($hotel->rooms && $hotel->rooms->count() > 0)
                            <div class="space-y-2">
                                <h4 class="text-sm font-semibold text-gray-700">
                                    Available Rooms
                                </h4>
                                <div class="space-y-1">
                                    @foreach ($hotel->rooms->take(3) as $room)
                                        <div
                                            class="flex justify-between text-sm"
                                        >
                                            <span class="text-gray-600">
                                                {{ $room->room_type }}
                                            </span>
                                            <span
                                                class="font-semibold text-emerald-600"
                                            >
                                                ${{ number_format($room->base_price, 2) }}
                                            </span>
                                        </div>
                                    @endforeach

                                    @if ($hotel->rooms->count() > 3)
                                        <div
                                            class="text-xs text-gray-500 text-center pt-1"
                                        >
                                            And
                                            {{ $hotel->rooms->count() - 3 }}
                                            more room types
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2">
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
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                            />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            No hotels found
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Try adjusting your search criteria or check back
                            later.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Call to Action -->
        @if (isset($hotels) && $hotels->count() > 0)
            <div class="text-center py-8">
                <div class="card max-w-2xl mx-auto">
                    <div class="card-body text-center">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            Need Help Choosing?
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Our travel experts are here to help you find the
                            perfect accommodation for your island adventure.
                        </p>
                        <div class="flex gap-4 justify-center">
                            <a
                                href="{{ route("contact") }}"
                                class="btn-primary"
                            >
                                Contact Us
                            </a>
                            <a href="{{ route("map") }}" class="btn-secondary">
                                View Map
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
