@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">All Rooms</h1>
                <p class="text-sm text-gray-600">
                    Manage all rooms across hotels
                </p>
            </div>
            <div>
                @if (count($hotels) > 0)
                    <div class="dropdown">
                        <button
                            class="btn-primary text-sm px-4 py-2 flex items-center gap-2"
                        >
                            Add New Room
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>
                        <div class="dropdown-content right-0 w-48 mt-2">
                            @foreach ($hotels as $hotel)
                                <a
                                    href="{{ route("hotels.rooms.create", $hotel) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                >
                                    {{ $hotel->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="p-4 border-b border-gray-200">
                <h2 class="font-semibold text-gray-900">Room Inventory</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="py-2 pr-4">Hotel</th>
                            <th class="py-2 pr-4">Room Number</th>
                            <th class="py-2 pr-4">Type</th>
                            <th class="py-2 pr-4">Occupancy</th>
                            <th class="py-2 pr-4">Price</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        @forelse ($rooms as $room)
                            <tr class="border-t border-gray-200">
                                <td class="py-2 pr-4">
                                    {{ $room->hotel->name ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    #{{ $room->room_number }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $room->room_type }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $room->max_occupancy }} persons
                                </td>
                                <td class="py-2 pr-4">
                                    ${{ number_format($room->base_price, 2) }}
                                </td>
                                <td class="py-2 pr-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{
                                            $room->status == "available"
                                                ? "bg-green-100 text-green-800"
                                                : ($room->status == "occupied"
                                                    ? "bg-blue-100 text-blue-800"
                                                    : "bg-red-100 text-red-800")
                                        }}"
                                    >
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td class="py-2 pr-4">
                                    <div class="flex space-x-3">
                                        <a
                                            href="{{ route("hotels.rooms.show", [$room->hotel, $room]) }}"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="View Room Details"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>
                                        </a>
                                        <a
                                            href="{{ route("hotels.rooms.edit", [$room->hotel, $room]) }}"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Edit Room"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                />
                                            </svg>
                                        </a>
                                        <form
                                            action="{{ route("hotels.rooms.destroy", [$room->hotel, $room]) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this room?');"
                                        >
                                            @csrf
                                            @method("DELETE")
                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-800"
                                                title="Delete Room"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                    />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="7"
                                    class="py-4 text-center text-gray-500"
                                >
                                    No rooms found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
@endsection
