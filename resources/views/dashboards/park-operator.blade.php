@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                <h4 class="text-sm font-medium text-red-800 mb-2">
                    Please fix the following errors:
                </h4>
                <ul class="text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session("success"))
            <div class="bg-green-50 border border-green-200 rounded-md p-4">
                <p class="text-sm text-green-800">{{ session("success") }}</p>
            </div>
        @endif

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Theme Park Operator Dashboard
                </h1>
                <p class="text-sm text-gray-600">
                    Manage activities, tickets, and verify bookings
                </p>
            </div>
            <div class="flex space-x-3">
                <a
                    href="{{ route("theme-park.create-activity") }}"
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
                    Add New Activity
                </a>
            </div>
        </div>

        <!-- Management Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route("theme-park.activities") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">
                            Total Activities
                        </div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $totalActivities ?? 0 }}
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
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage park activities
                </div>
            </a>
            <x-stat-card label="Active Activities" :value="$activeActivities ?? 0" valueClass="text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </x-stat-card>
            <a href="{{ route("theme-park.tickets") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">
                            Today's Visitors
                        </div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ $todayVisitors ?? 0 }}
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
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage today's entries
                </div>
            </a>
            <x-stat-card label="Upcoming Tickets" :value="$upcomingTickets ?? 0" valueClass="text-amber-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </x-stat-card>
        </div>

        <!-- Ticket Verification Tool -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card">
                    <div
                        class="p-4 border-b border-gray-200 flex items-center justify-between"
                    >
                        <h2 class="font-semibold text-gray-900">
                            Verify Hotel Booking
                        </h2>
                        <p class="text-sm text-gray-600">
                            Scan or enter confirmation code for park entry
                        </p>
                    </div>
                    <div class="p-6">
                        <form
                            id="park_verify_form"
                            class="space-y-4"
                            novalidate
                        >
                            @csrf
                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end"
                            >
                                <div class="md:col-span-2">
                                    <label
                                        for="park_confirmation_code"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Confirmation Code
                                    </label>
                                    <input
                                        id="park_confirmation_code"
                                        name="confirmation_code"
                                        type="text"
                                        required
                                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                                        placeholder="e.g. ABCD1234"
                                    />
                                    <p
                                        class="mt-1 text-sm text-red-600 hidden"
                                        data-error-for="park_confirmation_code"
                                    ></p>
                                </div>
                                <div>
                                    <button
                                        type="submit"
                                        class="btn-primary w-full"
                                    >
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div id="park_verify_result" class="mt-4 text-sm"></div>
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
                            ${{ number_format($totalMonthlyRevenue ?? 0, 2) }}
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <a
                            href="{{ route("reports.theme-park") }}"
                            class="text-sm text-blue-600 hover:underline"
                        >
                            View Revenue Report
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Management -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">
                        Popular Activities
                    </h2>
                    <a
                        href="{{ route("theme-park.activities") }}"
                        class="btn-secondary text-xs"
                    >
                        View All Activities
                    </a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Activity</th>
                                <th class="py-2 pr-4">Bookings</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($popularActivities ?? [] as $activity)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $activity->name ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800"
                                        >
                                            {{ $activity->activity_bookings_count ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div
                                            class="flex items-center justify-end space-x-2"
                                        >
                                            <a
                                                href="{{ route("theme-park.activities.show", $activity->id) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                                title="View Activity Details"
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
                                                href="{{ route("theme-park.edit-activity", $activity->id) }}"
                                                class="p-1 text-indigo-600 hover:text-indigo-800 transition-colors duration-200"
                                                title="Edit Activity"
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-4 text-gray-500">
                                        No activities
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ticket Management -->
            <div class="card">
                <div
                    class="p-4 border-b border-gray-200 flex items-center justify-between"
                >
                    <h2 class="font-semibold text-gray-900">Recent Tickets</h2>
                    <a
                        href="{{ route("theme-park.tickets") }}"
                        class="btn-secondary text-xs"
                    >
                        View All Tickets
                    </a>
                </div>
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-4">Guest</th>
                                <th class="py-2 pr-4">Visit Date</th>
                                <th class="py-2 pr-4">Tickets</th>
                                <th class="py-2 pr-4">Status</th>
                                <th class="py-2 pr-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-900">
                            @forelse ($recentBookings ?? [] as $ticket)
                                <tr class="border-t border-gray-200">
                                    <td class="py-2 pr-4">
                                        {{ $ticket->user->name ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->visit_date ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $ticket->num_tickets ?? "—" }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $ticket->ticket_status == "confirmed" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" }}"
                                        >
                                            {{ ucfirst($ticket->ticket_status ?? "—") }}
                                        </span>
                                    </td>
                                    <td class="py-2 pr-4">
                                        <div
                                            class="flex items-center justify-end space-x-2"
                                        >
                                            <a
                                                href="{{ route("theme-park.ticket.activities", $ticket->id) }}"
                                                class="p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                                title="View Ticket Details"
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
                                                href="{{ route("theme-park.tickets") }}"
                                                class="p-1 text-indigo-600 hover:text-indigo-800 transition-colors duration-200"
                                                title="Manage Ticket"
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
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-gray-500">
                                        No recent tickets
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var form = document.getElementById('park_verify_form');
                        var input = document.getElementById(
                            'park_confirmation_code',
                        );
                        var result =
                            document.getElementById('park_verify_result');

                        function setError(msg) {
                            var el = document.querySelector(
                                '[data-error-for="park_confirmation_code"]',
                            );
                            if (!el) return;
                            if (msg) {
                                el.textContent = msg;
                                el.classList.remove('hidden');
                                input.classList.add(
                                    'border-red-500',
                                    'ring-red-500',
                                );
                            } else {
                                el.textContent = '';
                                el.classList.add('hidden');
                                input.classList.remove(
                                    'border-red-500',
                                    'ring-red-500',
                                );
                            }
                        }
                        async function verify(e) {
                            e.preventDefault();
                            setError();
                            result.textContent = '';
                            var code = input.value.trim();
                            if (!code) {
                                setError('Please enter a confirmation code.');
                                return;
                            }
                            var token = form.querySelector(
                                'input[name="_token"]',
                            ).value;
                            try {
                                const res = await fetch(
                                    '{{ route("theme-park.verify-booking") }}',
                                    {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': token,
                                            Accept: 'application/json',
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            confirmation_code: code,
                                        }),
                                    },
                                );
                                const data = await res.json();
                                if (res.ok && data.valid) {
                                    result.className =
                                        'mt-4 text-sm p-3 rounded-md bg-green-50 text-green-800 border border-green-200';
                                    var msg =
                                        'Valid booking for <strong>' +
                                        (data.booking.guest_name || '') +
                                        '</strong> at ' +
                                        (data.booking.hotel || '') +
                                        '.';
                                    if (data.booking.has_park_ticket) {
                                        msg +=
                                            ' Park ticket found: ' +
                                            data.booking.park_ticket
                                                .num_tickets +
                                            ' ticket(s), status: ' +
                                            data.booking.park_ticket.status +
                                            '.';
                                    } else {
                                        msg += ' No park ticket for today.';
                                    }
                                    result.innerHTML = msg;
                                } else {
                                    result.className =
                                        'mt-4 text-sm p-3 rounded-md bg-red-50 text-red-800 border border-red-200';
                                    result.textContent =
                                        data.message || 'Invalid booking.';
                                }
                            } catch (err) {
                                result.className =
                                    'mt-4 text-sm p-3 rounded-md bg-red-50 text-red-800 border border-red-200';
                                result.textContent =
                                    'Verification failed. Please try again.';
                            }
                        }
                        form.addEventListener('submit', verify);
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
