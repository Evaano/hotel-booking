<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-semibold mb-6">
                        Theme Park Management
                    </h1>

                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-medium">Activities</h2>
                            <a
                                href="{{ route("theme-park.create-activity") }}"
                                class="btn-primary flex items-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-1"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Create New Activity
                            </a>
                        </div>

                        <div class="overflow-x-auto">
                            <table
                                class="min-w-full bg-white border border-gray-200"
                            >
                                <thead>
                                    <tr>
                                        <th
                                            class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b"
                                        >
                                            Activity Name
                                        </th>
                                        <th
                                            class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b"
                                        >
                                            Category
                                        </th>
                                        <th
                                            class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b"
                                        >
                                            Price
                                        </th>
                                        <th
                                            class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b"
                                        >
                                            Duration
                                        </th>
                                        <th
                                            class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b"
                                        >
                                            Status
                                        </th>
                                        <th
                                            class="py-3 px-4 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @forelse ($popularActivities as $activity)
                                        <tr>
                                            <td class="py-3 px-4">
                                                {{ $activity->name }}
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $activity->category }}
                                            </td>
                                            <td class="py-3 px-4">
                                                ${{ number_format($activity->price, 2) }}
                                            </td>
                                            <td class="py-3 px-4">
                                                {{ $activity->duration_minutes }}
                                                min
                                            </td>
                                            <td class="py-3 px-4">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $activity->status === "active" ? "bg-green-100 text-green-800" : "bg-gray-100 text-gray-800" }}"
                                                >
                                                    {{ ucfirst($activity->status) }}
                                                </span>
                                            </td>
                                            <td
                                                class="py-3 px-4 flex space-x-2"
                                            >
                                                <a
                                                    href="{{ route("theme-park.activities.show", $activity) }}"
                                                    class="text-blue-600 hover:text-blue-900"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                                        />
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </a>
                                                <a
                                                    href="{{ route("theme-park.edit-activity", $activity) }}"
                                                    class="text-indigo-600 hover:text-indigo-900"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-5 w-5"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                                        />
                                                    </svg>
                                                </a>
                                                <form
                                                    method="POST"
                                                    action="{{ route("theme-park.delete-activity", $activity) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this activity?');"
                                                    class="inline"
                                                >
                                                    @csrf
                                                    @method("DELETE")
                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-900"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5"
                                                            viewBox="0 0 20 20"
                                                            fill="currentColor"
                                                        >
                                                            <path
                                                                fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"
                                                            />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="6"
                                                class="py-4 px-4 text-center text-gray-500"
                                            >
                                                No activities found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-right">
                            <a
                                href="{{ route("theme-park.activities") }}"
                                class="btn-secondary inline-flex items-center"
                            >
                                <span>View All Activities</span>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 ml-1"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium mb-4">
                                Recent Bookings
                            </h3>
                            <div class="space-y-4">
                                @forelse ($recentBookings->take(5) as $ticket)
                                    <div class="border-b pb-3">
                                        <div class="flex justify-between">
                                            <div>
                                                <h4 class="font-medium">
                                                    {{ $ticket->user->name }}
                                                </h4>
                                                <p
                                                    class="text-sm text-gray-600"
                                                >
                                                    {{ $ticket->visit_date->format("M d, Y") }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm">
                                                    {{ $ticket->num_tickets }}
                                                    tickets
                                                </p>
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->ticket_status === "confirmed" ? "bg-green-100 text-green-800" : ($ticket->ticket_status === "pending" ? "bg-yellow-100 text-yellow-800" : "bg-gray-100 text-gray-800") }}"
                                                >
                                                    {{ ucfirst($ticket->ticket_status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">
                                        No recent bookings
                                    </p>
                                @endforelse
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-medium mb-4">
                                Verify Hotel Booking
                            </h3>
                            <form
                                action="{{ route("theme-park.verify-booking") }}"
                                method="POST"
                                class="space-y-4"
                            >
                                @csrf
                                <div>
                                    <x-input-label
                                        for="booking_reference"
                                        :value="__('Booking Reference')"
                                    />
                                    <x-text-input
                                        id="booking_reference"
                                        name="booking_reference"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <p class="text-sm text-gray-500 mt-1">
                                        Enter the hotel booking reference to
                                        verify
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <x-primary-button>Verify</x-primary-button>
                                </div>
                            </form>

                            @if (session("verification_result"))
                                <div
                                    class="mt-4 p-3 {{ session("verification_status") ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }} rounded"
                                >
                                    {{ session("verification_result") }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <div class="text-blue-600 mb-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 mx-auto"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $totalActivities }}
                            </h3>
                            <p class="text-gray-500">Total Activities</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <div class="text-blue-600 mb-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 mx-auto"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $todayVisitors }}
                            </h3>
                            <p class="text-gray-500">Today's Visitors</p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <div class="text-emerald-600 mb-2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-8 w-8 mx-auto"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">
                                ${{ number_format($totalMonthlyRevenue, 2) }}
                            </h3>
                            <p class="text-gray-500">Monthly Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
