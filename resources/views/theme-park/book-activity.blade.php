@extends("layouts.app")

@section("content")
    @php($ticket = $ticket ?? null)
    <div class="container max-w-5xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900">Book Activities</h1>

        <div class="card p-6 space-y-6">
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
                    <p class="text-sm text-green-800">
                        {{ session("success") }}
                    </p>
                </div>
            @endif

            <div class="text-sm text-gray-500">
                Ticket ID: {{ $ticket?->id ?? "—" }} · Visit:
                {{ $ticket?->visit_date }}
            </div>

            <form
                id="activity_booking_form"
                method="POST"
                action="{{ route("theme-park.store-activity", $ticket) }}"
                class="space-y-6"
                novalidate
            >
                @csrf

                <div>
                    <x-input-label
                        for="park_activity_id"
                        :value="__('Select Activity')"
                    />
                    <select
                        id="park_activity_id"
                        name="park_activity_id"
                        class="form-input"
                        required
                    >
                        <option value="">Choose an activity</option>
                        @php($bookedSet = collect($bookedActivities ?? []))
                        @foreach ($activities ?? [] as $activity)
                            @php($isBooked = $bookedSet->contains($activity->id))
                            <option
                                value="{{ $activity->id }}"
                                {{ $isBooked ? "disabled" : "" }}
                            >
                                {{ $activity->name . ($isBooked ? " — (Already booked)" : "") }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error
                        :messages="$errors->get('park_activity_id')"
                        class="mt-2"
                    />
                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="park_activity_id"
                    ></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="booking_time"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Preferred Time (optional)
                        </label>
                        <input
                            type="time"
                            id="booking_time"
                            name="booking_time"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
                    <div>
                        <label
                            for="num_participants"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Number of Participants
                        </label>
                        <input
                            type="number"
                            id="num_participants"
                            name="num_participants"
                            min="1"
                            max="{{ $ticket?->num_tickets ?? 1 }}"
                            value="{{ old("num_participants", 1) }}"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-xs text-gray-500"
                            id="participants_hint"
                        >
                            Up to {{ $ticket?->num_tickets ?? 1 }} participants
                            (based on your ticket count).
                        </p>
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="num_participants"
                        ></p>
                    </div>
                </div>

                <div>
                    <x-primary-button type="submit">
                        {{ __("Add Activity") }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('activity_booking_form');
                    var activitySel =
                        document.getElementById('park_activity_id');
                    var timeInput = document.getElementById('booking_time');
                    var numInput = document.getElementById('num_participants');
                    var submitBtn = form.querySelector('button[type="submit"]');
                    var ticketMax = parseInt(
                        numInput.getAttribute('max') || '1',
                        10,
                    );

                    function setError(id, msg) {
                        var el = document.querySelector(
                            '[data-error-for="' + id + '"]',
                        );
                        var input = document.getElementById(id);
                        if (!el || !input) return;
                        if (msg) {
                            el.textContent = msg;
                            el.classList.remove('hidden');
                            input.classList.add(
                                'border-red-500',
                                'ring-red-500',
                            );
                            input.setAttribute('aria-invalid', 'true');
                        } else {
                            el.textContent = '';
                            el.classList.add('hidden');
                            input.classList.remove(
                                'border-red-500',
                                'ring-red-500',
                            );
                            input.removeAttribute('aria-invalid');
                        }
                    }

                    function disableSubmit(dis) {
                        submitBtn.disabled = !!dis;
                        submitBtn.classList.toggle('opacity-50', !!dis);
                        submitBtn.classList.toggle('cursor-not-allowed', !!dis);
                    }

                    function validateRealtime() {
                        var hasErr = false;
                        // Activity
                        if (!activitySel.value) {
                            setError(
                                'park_activity_id',
                                'Please select an activity.',
                            );
                            hasErr = true;
                        } else if (
                            activitySel.options[activitySel.selectedIndex]
                                .disabled
                        ) {
                            setError(
                                'park_activity_id',
                                'This activity is already booked.',
                            );
                            hasErr = true;
                        } else {
                            setError('park_activity_id');
                        }
                        // Participants
                        var val = parseInt(numInput.value || '0', 10);
                        if (!val || val < 1) {
                            setError(
                                'num_participants',
                                'Enter at least 1 participant.',
                            );
                            hasErr = true;
                        } else if (val > ticketMax) {
                            setError(
                                'num_participants',
                                'Maximum allowed is ' + ticketMax + '.',
                            );
                            hasErr = true;
                        } else {
                            setError('num_participants');
                        }

                        disableSubmit(hasErr);
                        return !hasErr;
                    }

                    if (activitySel) {
                        activitySel.addEventListener(
                            'change',
                            validateRealtime,
                        );
                    }
                    if (numInput) {
                        numInput.addEventListener('input', validateRealtime);
                    }
                    if (timeInput) {
                        timeInput.addEventListener('input', function () {
                            /* no-op basic */
                        });
                    }

                    validateRealtime();
                    form.addEventListener('submit', function (e) {
                        if (!validateRealtime()) e.preventDefault();
                    });
                });
            </script>
        </div>

        <div class="card p-6">
            <h2 class="font-semibold text-gray-900">Already Booked</h2>
            <ul class="mt-2 text-sm space-y-1">
                @forelse ($ticket?->activityBookings ?? [] as $ba)
                    <li class="text-gray-600">
                        {{ $ba->parkActivity->name ?? "—" }}
                        ({{ $ba->num_participants }} people)
                    </li>
                @empty
                    <li class="text-gray-500">No activities booked</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
