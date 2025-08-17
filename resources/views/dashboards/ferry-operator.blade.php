@extends("layouts.app")

@section("content")
    <div class="container py-8 space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    {{ auth()->user()->isAdmin() ? 'Ferry Management (Admin)' : 'Ferry Operator Dashboard' }}
                </h1>
                <p class="text-sm text-gray-600">
                    {{ auth()->user()->isAdmin() ? 'View all schedules and tickets across operators' : 'Manage ferry operations and verify bookings' }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a
                    href="{{ route("ferry.create-schedule") }}"
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
                    Add New Schedule
                </a>
            </div>
        </div>

        <!-- Management Quick Links -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route("ferry.schedules") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">{{ auth()->user()->isAdmin() ? 'All Schedules' : 'My Schedules' }}</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ ($schedules ?? collect())->count() }}
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
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    Manage ferry schedules
                </div>
            </a>
            <a href="{{ route("ferry.tickets") }}" class="card p-6 hover:bg-gray-50 transition duration-300 cursor-pointer">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Today's Tickets</div>
                        <div class="mt-2 text-2xl font-bold text-gray-900">
                            {{ ($todayTickets ?? collect())->count() }}
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
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    View today's passenger list
                </div>
            </a>
            <x-stat-card label="Upcoming Tickets" :value="$upcomingTickets ?? 0">
                <div class="flex items-center justify-between">
                    <div class="text-primary-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="mt-2 text-xs text-gray-600">Future reservations</div>
            </x-stat-card>
            <x-stat-card label="Capacity Utilization" :value="($capacityUtilization ?? 0) . '%'" valueClass="text-amber-600">
                <div class="flex items-center justify-between">
                    <div class="text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
                <div class="mt-2 text-xs text-gray-600">Today's capacity usage</div>
            </x-stat-card>
        </div>

        <!-- Ticket Verification Tool -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="card">
                    <div
                        class="p-4 border-b border-gray-200 flex items-center justify-between"
                    >
                        <h2 class="font-semibold text-gray-900">Verify Hotel Booking</h2>
                        <p class="text-sm text-gray-600">
                            Scan or enter confirmation code
                        </p>
                    </div>
                    <div class="p-6">
                        <form
                            id="ferry_verify_form"
                            class="space-y-4"
                            novalidate
                        >
                            @csrf
                            <div
                                class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end"
                            >
                                <div class="md:col-span-2">
                                    <label
                                        for="ferry_confirmation_code"
                                        class="block text-sm font-medium text-gray-700 mb-1"
                                    >
                                        Confirmation Code
                                    </label>
                                    <input
                                        id="ferry_confirmation_code"
                                        name="confirmation_code"
                                        type="text"
                                        required
                                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                                        placeholder="e.g. ABCD1234"
                                    />
                                    <p
                                        class="mt-1 text-sm text-red-600 hidden"
                                        data-error-for="ferry_confirmation_code"
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
                        <div
                            id="ferry_verify_result"
                            class="mt-4 text-sm"
                        ></div>
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

        <!-- Today's Tickets -->
        <div class="card">
            <div
                class="p-4 border-b border-gray-200 flex items-center justify-between"
            >
                <h2 class="font-semibold text-gray-900">Today's Tickets</h2>
                <a
                    href="{{ route("ferry.tickets") }}"
                    class="btn-secondary text-xs"
                >
                    View All Tickets
                </a>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="text-left text-gray-500">
                        <tr>
                            <th class="py-2 pr-4">Passenger</th>
                            <th class="py-2 pr-4">Schedule</th>
                            <th class="py-2 pr-4">Date</th>
                            <th class="py-2 pr-4">Passengers</th>
                            <th class="py-2 pr-4">Status</th>
                            <th class="py-2 pr-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900">
                        @forelse ($todayTickets ?? [] as $ticket)
                            <tr class="border-t border-gray-200">
                                <td class="py-2 pr-4">
                                    {{ $ticket->user->name ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    #{{ $ticket->ferrySchedule->id ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $ticket->travel_date ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    {{ $ticket->num_passengers ?? "—" }}
                                </td>
                                <td class="py-2 pr-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full {{ $ticket->booking_status == "confirmed" ? "bg-green-100 text-green-800" : "bg-yellow-100 text-yellow-800" }}"
                                    >
                                        {{ ucfirst($ticket->booking_status ?? "—") }}
                                    </span>
                                </td>
                                <td class="py-2 pr-4">
                                    <div
                                        class="flex items-center justify-end space-x-2"
                                    >
                                        <a
                                            href="{{ route('ferry.tickets.show', $ticket->id) }}"
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500">
                                    No tickets for today
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var form = document.getElementById('ferry_verify_form');
                var input = document.getElementById('ferry_confirmation_code');
                var result = document.getElementById('ferry_verify_result');

                function setError(msg) {
                    var el = document.querySelector(
                        '[data-error-for="ferry_confirmation_code"]',
                    );
                    if (!el) return;
                    if (msg) {
                        el.textContent = msg;
                        el.classList.remove('hidden');
                        input.classList.add('border-red-500', 'ring-red-500');
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
                            '{{ route("ferry.verify-booking") }}',
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
                            result.innerHTML =
                                'Valid booking for <strong>' +
                                (data.booking.guest_name || '') +
                                '</strong> at ' +
                                (data.booking.hotel || '') +
                                ' (Check-in: ' +
                                data.booking.check_in +
                                ', Check-out: ' +
                                data.booking.check_out +
                                ')';
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
@endsection
