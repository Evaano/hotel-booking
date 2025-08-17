@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Maldives Map</h1>
            <p class="text-sm text-gray-600">
                Browse locations and nearby hotels.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <div class="lg:col-span-2 card overflow-hidden self-start">
                <div id="island-map" class="w-full h-[28rem]"></div>
            </div>
            <div class="card p-4">
                <h2 class="font-semibold text-gray-900 mb-3">Locations</h2>
                <div class="space-y-2 max-h-80 overflow-auto">
                    @foreach ($groupedLocations ?? [] as $island => $locations)
                        <div>
                            <div class="text-sm font-medium text-gray-700">
                                {{ \Illuminate\Support\Str::of($island)->replace("_", " ")->title() }}
                            </div>
                            <ul
                                class="list-disc list-inside text-sm text-gray-600"
                            >
                                @foreach ($locations as $loc)
                                    <li>
                                        <button
                                            type="button"
                                            class="text-left hover:underline cursor-pointer js-pan-to"
                                            data-lat="{{ $loc->latitude }}"
                                            data-lng="{{ $loc->longitude }}"
                                            data-name="{{ $loc->name }}"
                                            data-type="{{ $loc->type }}"
                                        >
                                            {{ $loc->name ?? "—" }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

                <h2 class="font-semibold text-gray-900 mt-6 mb-3">Hotels</h2>
                <ul class="space-y-2 max-h-64 overflow-auto text-sm">
                    @forelse ($hotels ?? [] as $hotel)
                        <li
                            class="flex items-center justify-between border rounded-lg px-3 py-2 border-gray-200"
                        >
                            <button
                                type="button"
                                class="text-left hover:underline cursor-pointer js-pan-to"
                                data-lat="{{ $hotel->latitude }}"
                                data-lng="{{ $hotel->longitude }}"
                                data-name="{{ $hotel->name }}"
                                data-type="hotel"
                            >
                                {{ $hotel->name ?? "—" }}
                            </button>
                            <span class="text-xs text-gray-500">
                                #{{ $hotel->id ?? "" }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-500">No hotels</li>
                    @endforelse
                </ul>

                <h2 class="font-semibold text-gray-900 mt-6 mb-3">
                    Upcoming Events
                </h2>
                <ul class="space-y-2 max-h-64 overflow-auto text-sm">
                    @forelse ($events ?? [] as $event)
                        <li
                            class="flex items-center justify-between border rounded-lg px-3 py-2 border-gray-200"
                        >
                            <button
                                type="button"
                                class="text-left hover:underline cursor-pointer js-pan-to"
                                data-lat="{{ $event->latitude }}"
                                data-lng="{{ $event->longitude }}"
                                data-name="{{ $event->name }}"
                                data-type="{{ \Illuminate\Support\Str::of($event->event_type)->replace("_", " ")->title() }}"
                            >
                                {{ $event->name ?? "—" }}
                            </button>
                            <span class="text-xs text-gray-500">
                                {{ optional($event->event_date)->format("Y-m-d") }}
                                · {{ $event->location ?? "" }}
                            </span>
                        </li>
                    @empty
                        <li class="text-gray-500">No events</li>
                    @endforelse
                </ul>
            </div>
        </div>

        @push("styles")
            <link
                rel="stylesheet"
                href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            />
        @endpush

        @push("scripts")
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            @php
                $locationsData = ($groupedLocations ?? collect())
                    ->flatten(1)
                    ->values()
                    ->map(function ($l) {
                        return [
                            "name" => $l->name,
                            "lat" => $l->latitude,
                            "lng" => $l->longitude,
                            "type" => $l->type,
                        ];
                    })
                    ->all();

                $hotelsData = ($hotels ?? collect())
                    ->values()
                    ->map(function ($h) {
                        return [
                            "id" => $h->id,
                            "name" => $h->name,
                            "lat" => $h->latitude,
                            "lng" => $h->longitude,
                            "url" => route("hotels.show", $h),
                        ];
                    })
                    ->all();

                $eventsData = ($events ?? collect())
                    ->values()
                    ->map(function ($e) {
                        return [
                            "id" => $e->id,
                            "name" => $e->name,
                            "lat" => $e->latitude,
                            "lng" => $e->longitude,
                            "location" => $e->location,
                            "date" => optional($e->event_date)->format("Y-m-d"),
                            "type" => $e->event_type,
                            "url" => route("beach-events.show", $e),
                        ];
                    })
                    ->all();
            @endphp

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    setTimeout(function () {
                        const map = L.map('island-map');

                        L.tileLayer(
                            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                            { attribution: '© OpenStreetMap contributors' },
                        ).addTo(map);

                        const locations = @json($locationsData);
                        const hotels = @json($hotelsData);
                        const events = @json($eventsData);

                        const markerByLatLng = new Map();
                        const allBounds = L.latLngBounds([]);

                        const toKey = (lat, lng) => {
                            const a = Number(lat);
                            const b = Number(lng);
                            if (Number.isNaN(a) || Number.isNaN(b)) return null;
                            return `${a.toFixed(6)},${b.toFixed(6)}`;
                        };

                        const normalizeType = (t) => {
                            if (!t) return '';
                            return String(t)
                                .replaceAll('_', ' ')
                                .replace(/\s+/g, ' ')
                                .trim()
                                .replace(/\b\w/g, (c) => c.toUpperCase());
                        };

                        // Add location markers
                        locations.forEach((loc) => {
                            if (loc.lat && loc.lng) {
                                const lat = parseFloat(loc.lat);
                                const lng = parseFloat(loc.lng);
                                const m = L.marker([lat, lng])
                                    .addTo(map)
                                    .bindPopup(
                                        `<strong>${loc.name}</strong><br/><small>${normalizeType(loc.type)}</small>`,
                                    );
                                const key = toKey(lat, lng);
                                if (key) markerByLatLng.set(key, m);
                                allBounds.extend([lat, lng]);
                            }
                        });

                        // Add hotel markers
                        hotels.forEach((hotel) => {
                            if (hotel.lat && hotel.lng) {
                                const lat = parseFloat(hotel.lat);
                                const lng = parseFloat(hotel.lng);
                                const m = L.marker([lat, lng])
                                    .addTo(map)
                                    .bindPopup(
                                        `<strong>${hotel.name}</strong><br/><small>Hotel</small><br/><a href="${hotel.url}" class="inline-block mt-1 text-blue-600 hover:underline">View details</a>`,
                                    );
                                const key = toKey(lat, lng);
                                if (key) markerByLatLng.set(key, m);
                                allBounds.extend([lat, lng]);
                            }
                        });

                        // Add event markers as circles
                        events.forEach((ev) => {
                            if (ev.lat && ev.lng) {
                                const lat = parseFloat(ev.lat);
                                const lng = parseFloat(ev.lng);
                                const m = L.circleMarker([lat, lng], {
                                    radius: 7,
                                    color: '#b91c1c',
                                    fillColor: '#ef4444',
                                    fillOpacity: 0.8,
                                    weight: 2,
                                })
                                    .addTo(map)
                                    .bindPopup(
                                        `<strong>${ev.name}</strong><br/><small>${ev.type} • ${ev.date}</small><br/><small>${ev.location || ''}</small><br/><a href="${ev.url}" class="inline-block mt-1 text-blue-600 hover:underline">View details</a>`,
                                    );
                                const key = toKey(lat, lng);
                                if (key) markerByLatLng.set(key, m);
                                allBounds.extend([lat, lng]);
                            }
                        });

                        // Auto-fit to bounds if we have any markers; else default center
                        if (allBounds.isValid()) {
                            map.fitBounds(allBounds, {
                                padding: [24, 24],
                                maxZoom: 15,
                            });
                        } else {
                            // Default to Hulhumalé, Maldives if no markers
                            map.setView([4.2105, 73.5453], 13);
                        }

                        // Sidebar interaction: pan to and open popup
                        document
                            .querySelectorAll('.js-pan-to')
                            .forEach((el) => {
                                el.addEventListener('click', () => {
                                    const lat = parseFloat(el.dataset.lat);
                                    const lng = parseFloat(el.dataset.lng);
                                    if (!isNaN(lat) && !isNaN(lng)) {
                                        map.setView([lat, lng], 15);
                                        const key = toKey(lat, lng);
                                        const marker = key
                                            ? markerByLatLng.get(key)
                                            : null;
                                        if (marker && marker.openPopup) {
                                            marker.openPopup();
                                        }
                                    }
                                });
                            });
                    }, 100);
                });
            </script>
        @endpush
    </div>
@endsection
