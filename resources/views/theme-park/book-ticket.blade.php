@extends("layouts.app")

@section("content")
    <div class="container max-w-4xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">
            Book Theme Park Ticket
        </h1>
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

            <form
                id="park_ticket_form"
                method="POST"
                action="{{ route("theme-park.store-ticket") }}"
                class="space-y-6"
                novalidate
            >
                @csrf

                <div>
                    <x-input-label
                        for="room_booking_id"
                        :value="__('Select Your Hotel Booking')"
                    />
                    <select
                        id="room_booking_id"
                        name="room_booking_id"
                        class="form-input"
                        required
                    >
                        <option value="">Choose a confirmed booking</option>
                        @foreach ($validBookings ?? [] as $booking)
                            <option
                                value="{{ $booking->id }}"
                                data-check-in="{{ $booking->check_in_date }}"
                                data-check-out="{{ $booking->check_out_date }}"
                            >
                                {{ ($booking->room->hotel->name ?? "Hotel") . " — Room #" . ($booking->room->room_number ?? "") . " (" . $booking->check_in_date . " → " . $booking->check_out_date . ")" }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error
                        :messages="$errors->get('room_booking_id')"
                        class="mt-2"
                    />
                    <p
                        class="form-error hidden"
                        data-error-for="room_booking_id"
                    ></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="visit_date" value="Visit Date" />
                        <x-text-input
                            type="date"
                            id="visit_date"
                            name="visit_date"
                            required
                        />
                        <p class="mt-1 text-xs text-muted-500" id="visit_hint">
                            Select your hotel booking first.
                        </p>
                        <p
                            class="form-error hidden"
                            data-error-for="visit_date"
                        ></p>
                    </div>
                    <div>
                        <x-input-label
                            for="num_tickets"
                            value="Number of Tickets"
                        />
                        <x-text-input
                            type="number"
                            id="num_tickets"
                            name="num_tickets"
                            min="1"
                            max="10"
                            value="{{ old('num_tickets', 1) }}"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="num_tickets"
                        ></p>
                    </div>
                </div>

                <div>
                    <x-primary-button type="submit">
                        {{ __("Book Tickets") }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('park_ticket_form');
                    var bookingSel = document.getElementById('room_booking_id');
                    var dateInput = document.getElementById('visit_date');
                    var hint = document.getElementById('visit_hint');
                    var ticketsInput = document.getElementById('num_tickets');
                    var submitBtn = form.querySelector('button[type="submit"]');

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
                                'border-error-500',
                                'ring-error-500',
                            );
                            input.setAttribute('aria-invalid', 'true');
                        } else {
                            el.textContent = '';
                            el.classList.add('hidden');
                            input.classList.remove(
                                'border-error-500',
                                'ring-error-500',
                            );
                            input.removeAttribute('aria-invalid');
                        }
                    }

                    function parseDate(v) {
                        var d = new Date(v);
                        return isNaN(d.getTime()) ? null : d;
                    }
                    function disableSubmit(dis) {
                        submitBtn.disabled = !!dis;
                        submitBtn.classList.toggle('opacity-50', !!dis);
                        submitBtn.classList.toggle('cursor-not-allowed', !!dis);
                    }

                    function syncBounds() {
                        var opt =
                            bookingSel &&
                            bookingSel.options[bookingSel.selectedIndex];
                        var min = opt
                            ? opt.getAttribute('data-check-in')
                            : null;
                        var max = opt
                            ? opt.getAttribute('data-check-out')
                            : null;
                        if (min) {
                            dateInput.min = min;
                        } else {
                            dateInput.removeAttribute('min');
                        }
                        if (max) {
                            dateInput.max = max;
                        } else {
                            dateInput.removeAttribute('max');
                        }
                        if (hint) {
                            if (min && max)
                                hint.textContent =
                                    'Must be between ' +
                                    min +
                                    ' and ' +
                                    max +
                                    '.';
                            else
                                hint.textContent =
                                    'Select your hotel booking first.';
                        }
                    }

                    function validateRealtime() {
                        var hasErr = false;
                        // Booking
                        if (!bookingSel.value) {
                            setError(
                                'room_booking_id',
                                'Please select a hotel booking.',
                            );
                            hasErr = true;
                        } else {
                            setError('room_booking_id');
                        }
                        // Date
                        var d = parseDate(dateInput.value);
                        var min = dateInput.min
                            ? parseDate(dateInput.min)
                            : null;
                        var max = dateInput.max
                            ? parseDate(dateInput.max)
                            : null;
                        if (!d) {
                            setError(
                                'visit_date',
                                'Please choose a visit date.',
                            );
                            hasErr = true;
                        } else {
                            var today = new Date();
                            today.setHours(0, 0, 0, 0);
                            if (min && d < min) {
                                setError(
                                    'visit_date',
                                    'Date must be on/after ' +
                                        dateInput.min +
                                        '.',
                                );
                                hasErr = true;
                            } else if (max && d > max) {
                                setError(
                                    'visit_date',
                                    'Date must be on/before ' +
                                        dateInput.max +
                                        '.',
                                );
                                hasErr = true;
                            } else if (d < today) {
                                setError(
                                    'visit_date',
                                    'Date cannot be in the past.',
                                );
                                hasErr = true;
                            } else {
                                setError('visit_date');
                            }
                        }
                        // Tickets
                        var t = parseInt(ticketsInput.value || '0', 10);
                        if (!t || t < 1) {
                            setError('num_tickets', 'Enter at least 1 ticket.');
                            hasErr = true;
                        } else if (t > 10) {
                            setError('num_tickets', 'Maximum allowed is 10.');
                            hasErr = true;
                        } else {
                            setError('num_tickets');
                        }

                        disableSubmit(hasErr);
                        return !hasErr;
                    }

                    if (bookingSel) {
                        bookingSel.addEventListener('change', function () {
                            syncBounds();
                            validateRealtime();
                        });
                    }
                    if (dateInput) {
                        dateInput.addEventListener('input', validateRealtime);
                    }
                    if (ticketsInput) {
                        ticketsInput.addEventListener(
                            'input',
                            validateRealtime,
                        );
                    }

                    syncBounds();
                    validateRealtime();
                    form.addEventListener('submit', function (e) {
                        if (!validateRealtime()) e.preventDefault();
                    });
                });
            </script>
        </div>
    </div>
@endsection
