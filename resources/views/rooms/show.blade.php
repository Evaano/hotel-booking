@extends("layouts.app")

@section("content")
    @php($entity = $room ?? null)
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            Room Details
        </h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                @if($room)
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Id</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">{{ $room->id }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Room Number</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">{{ $room->room_number }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Room Type</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">
                            {{ \App\Models\Room::getRoomTypes()[$room->room_type] ?? ucfirst($room->room_type) }}
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Description</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">{{ $room->description ?? 'No description' }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Max Occupancy</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">{{ $room->max_occupancy }} {{ $room->max_occupancy == 1 ? 'guest' : 'guests' }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Base Price</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">${{ number_format($room->base_price, 2) }} per night</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Amenities</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">
                            @if($room->amenities && is_array($room->amenities) && count($room->amenities) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($room->amenities as $amenity)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500">No amenities listed</span>
                            @endif
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $room->status === 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Hotel</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">
                            <a href="{{ route('hotels.show', $room->hotel) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $room->hotel->name }}
                            </a>
                        </dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Created At</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">{{ $room->created_at?->format('M d, Y H:i') }}</dd>
                    </div>
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">Updated At</dt>
                        <dd class="col-span-2 text-sm text-gray-900 dark:text-gray-100">{{ $room->updated_at?->format('M d, Y H:i') }}</dd>
                    </div>
                @else
                    <div class="text-gray-500 dark:text-gray-400">Room not found</div>
                @endif
            </dl>
        </div>
    </div>
@endsection
