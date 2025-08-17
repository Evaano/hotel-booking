@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Hotel Operator Dashboard
                </h1>
                <p class="text-sm text-gray-600">
                    Manage your properties and bookings
                </p>
            </div>
            <div class="flex space-x-3">
                <a
                    href="{{ route("hotels.create") }}"
                    class="btn-primary flex items-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Add New Hotel
                </a>
                <a
                    href="{{ route("rooms.create") }}"
                    class="btn-secondary flex items-center"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />
                    </svg>
                    Add New Room
                </a>
            </div>
        </div>

        <!-- Management Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a
                href="{{ route("hotels.index") }}"
                class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">My Hotels</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ count($hotels ?? []) }}
                        </div>
                    </div>
                    <div class="text-primary-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
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
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage your properties
                </div>
            </a>
            <a
                href="{{ route("rooms.index") }}"
                class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Total Rooms</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $totalRooms ?? 0 }}
                        </div>
                    </div>
                    <div class="text-primary-600">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage your room inventory
                </div>
            </a>
            <x-stat-card label="Available" :value="$availableRooms ?? 0" valueClass="text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-stat-card>
            <x-stat-card label="Occupied" :value="$occupiedRooms ?? 0" valueClass="text-rose-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-stat-card>
        </div>

        <!-- Today's Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card">
                    <div
                        class="p-4 border-b border-gray-200 flex items-center justify-between"
                    >
                        <h2 class="font-semibold text-gray-900">
                            Today's Activity
                        </h2>
                        <div class="text-sm text-gray-600">
                            {{ now()->format("F j, Y") }}
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <x-stat-card label="Check-ins Today" :value="$todayCheckIns ?? 0" valueClass="text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </x-stat-card>
                            <div class="mt-2">
                                <a href="#" class="text-sm text-blue-600 hover:underline">View check-in list</a>
                            </div>
                        </div>
                        <div>
                            <x-stat-card label="Check-outs Today" :value="$todayCheckOuts ?? 0" valueClass="text-amber-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </x-stat-card>
                            <div class="mt-2">
                                <a href="#" class="text-sm text-amber-600 hover:underline">View check-out list</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <h2 class="font-semibold text-gray-900 mb-4">
                    Revenue Overview
                </h2>
                <div class="space-y-4">
                    <div>
                        <div class="text-sm text-gray-500">Monthly Revenue</div>
                        <div class="mt-1 text-2xl font-bold text-gray-900">
                            ${{ number_format($monthlyRevenue ?? 0, 2) }}
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <a
                            href="#"
                            class="text-sm text-blue-600 hover:underline"
                        >
                            View Revenue Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Management -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">Recent Bookings</h2>
                <a
                    href="#"
                    class="btn-secondary text-xs"
                >
                    View All Bookings
                </a>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="py-2 pr-4">Guest</th>
                            <th class="py-2 pr-4">Hotel</th>
                            <th class="py-2 pr-4">Room</th>
                            <th class="py-2 pr-4">Dates</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        @forelse ($recentBookings ?? [] as $booking)
                            <tr class="border-t border-gray-200">
                                <td class="py-2 pr-4">
                                    {{ $booking->user->name ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $booking->room->hotel->name ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    #{{ $booking->room->room_number ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $booking->check_in_date }} →
                                    {{ $booking->check_out_date }}
                                </td>
                                <td class="py-2 pr-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $booking->booking_status == "confirmed" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" }}"
                                    >
                                        {{ ucfirst($booking->booking_status ?? "—") }}
                                    </span>
                                </td>
                                <td class="py-2 pr-4 text-right">
                                    <div class="flex items-center justify-end space-x-3">
                                        <a
                                            href="#"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="View Booking Details"
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
                                            href="#"
                                            class="text-blue-600 hover:text-blue-800"
                                            title="Edit Booking"
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
                                        <a
                                            href="#"
                                            class="text-green-600 hover:text-green-800"
                                            title="Confirm Booking"
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
                                                    d="M5 13l4 4L19 7"
                                                />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500">
                                    No recent bookings
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
