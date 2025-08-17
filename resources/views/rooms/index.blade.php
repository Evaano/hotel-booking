@extends("layouts.app")

@section("content")
    @php($hotel = $hotel ?? null)
    <div class="max-w-7xl mx-auto p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                Rooms
                @if ($hotel)
                    <span class="text-gray-500 text-lg">
                        — {{ $hotel->name }}
                    </span>
                @endif
            </h1>
            @if ($hotel)
                <a
                    href="{{ route("hotels.rooms.create", $hotel) }}"
                    class="btn-primary"
                >
                    Create Room
                </a>
            @endif
        </div>
        <div
            class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden"
        >
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            ID
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Number
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
                    @forelse ($rooms ?? [] as $room)
                        <tr class="hover:bg-gray-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ $room->id }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                #{{ $room->room_number }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"
                            >
                                {{ ucfirst($room->status ?? "—") }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm"
                            >
                                <div class="inline-flex gap-3">
                                    <a
                                        href="{{ route("hotels.rooms.show", [$hotel, $room]) }}"
                                        class="text-blue-600 hover:text-blue-800"
                                    >
                                        View
                                    </a>
                                    <a
                                        href="{{ route("hotels.rooms.edit", [$hotel, $room]) }}"
                                        class="text-indigo-600 hover:text-indigo-800"
                                    >
                                        Edit
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route("hotels.rooms.destroy", [$hotel, $room]) }}"
                                        onsubmit="return confirm('Delete this room?');"
                                        class="inline"
                                    >
                                        @csrf
                                        @method("DELETE")
                                        <button
                                            type="submit"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                No rooms found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
