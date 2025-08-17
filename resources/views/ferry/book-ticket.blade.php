@extends("layouts.app")

@section("content")
    <div class="container max-w-4xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">Book Ferry Ticket</h1>
        <div class="card p-6 space-y-4">
            <form
                id="ferry_ticket_form"
                method="POST"
                action="{{ route("ferry.store-ticket") }}"
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

                <div>
                    <x-input-label
                        for="ferry_schedule_id"
                        :value="__('Ferry Schedule')"
                    />
                    <select
                        id="ferry_schedule_id"
                        name="ferry_schedule_id"
                        class="form-input"
                        required
                    >
                        <option value="">Choose a schedule</option>
                        @foreach ($schedules ?? [] as $schedule)
                            <option
                                value="{{ $schedule->id }}"
                                data-label="{{ $schedule->route . " — " . \Carbon\Carbon::parse($schedule->departure_time)->format("H:i") . " → " . \Carbon\Carbon::parse($schedule->arrival_time)->format("H:i") . " (" . $schedule->price . " per passenger)" }}"
                                data-days="@json($schedule->days_of_week ?? [])"
                            >
                                {{ $schedule->route . " — " . \Carbon\Carbon::parse($schedule->departure_time)->format("H:i") . " → " . \Carbon\Carbon::parse($schedule->arrival_time)->format("H:i") . " (" . $schedule->price . " per passenger)" }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error
                        :messages="$errors->get('ferry_schedule_id')"
                        class="mt-2"
                    />
                    <p
                        class="mt-1 text-xs text-muted-500"
                        id="schedule_hint"
                    ></p>
                    <p
                        class="form-error hidden"
                        data-error-for="ferry_schedule_id"
                    ></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="travel_date" value="Travel Date" />
                        <x-text-input
                            type="date"
                            id="travel_date"
                            name="travel_date"
                            required
                        />
                        <p class="mt-1 text-xs text-muted-500" id="travel_hint">
                            Select a booking and schedule first.
                        </p>
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="travel_date"
                        ></p>
                    </div>
                    <div>
                        <x-input-label
                            for="num_passengers"
                            value="Number of Passengers"
                        />
                        <x-text-input
                            type="number"
                            id="num_passengers"
                            name="num_passengers"
                            min="1"
                            max="10"
                            value="{{ old('num_passengers', 1) }}"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="num_passengers"
                        ></p>
                    </div>
                </div>

                <div>
                    <x-primary-button type="submit">
                        {{ __("Book Ticket") }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('ferry_ticket_form');
                    var bookingSel = document.getElementById('room_booking_id');
                    var scheduleSel =
                        document.getElementById('ferry_schedule_id');
                    var dateInput = document.getElementById('travel_date');
                    var paxInput = document.getElementById('num_passengers');
                    var hint = document.getElementById('travel_hint');
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
                    function dayName(d) {
                        return d
                            .toLocaleDateString('en-US', { weekday: 'long' })
                            .toLowerCase();
                    }
                    function disableSubmit(dis) {
                        submitBtn.disabled = !!dis;
                        submitBtn.classList.toggle('opacity-50', !!dis);
                        submitBtn.classList.toggle('cursor-not-allowed', !!dis);
                    }

                    function syncDateBounds() {
                        var opt =
                            bookingSel &&
                            bookingSel.options[bookingSel.selectedIndex];
                        var inDate = opt
                            ? opt.getAttribute('data-check-in')
                            : null;
                        var outDate = opt
                            ? opt.getAttribute('data-check-out')
                            : null;
                        if (inDate) {
                            dateInput.min = inDate;
                        } else {
                            dateInput.removeAttribute('min');
                        }
                        if (outDate) {
                            dateInput.max = outDate;
                        } else {
                            dateInput.removeAttribute('max');
                        }
                        if (hint) {
                            if (inDate && outDate) {
                                hint.textContent =
                                    'Must be between ' +
                                    inDate +
                                    ' and ' +
                                    outDate +
                                    '.';
                            } else {
                                hint.textContent =
                                    'Select a booking and schedule first.';
                            }
                        }
                    }

                    function filterSchedulesByDate() {
                        var d = parseDate(dateInput.value);
                        var day = d ? dayName(d) : null;
                        var countEnabled = 0;
                        for (var i = 0; i < scheduleSel.options.length; i++) {
                            var opt = scheduleSel.options[i];
                            if (!opt.value) continue;
                            var allowed = [];
                            try {
                                allowed = JSON.parse(
                                    opt.getAttribute('data-days') || '[]',
                                );
                            } catch (e) {}
                            var label =
                                opt.getAttribute('data-label') ||
                                opt.textContent;
                            if (
                                !day ||
                                !allowed.length ||
                                allowed.indexOf(day) !== -1
                            ) {
                                opt.disabled = false;
                                opt.textContent = label;
                                countEnabled++;
                            } else {
                                opt.disabled = true;
                                opt.textContent =
                                    label + ' (not operating this day)';
                            }
                        }
                        var sh = document.getElementById('schedule_hint');
                        if (sh) {
                            if (!day)
                                sh.textContent =
                                    'Select a travel date to filter schedules.';
                            else
                                sh.textContent =
                                    countEnabled +
                                    ' schedule' +
                                    (countEnabled === 1 ? '' : 's') +
                                    ' available for this date.';
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
                        // Schedule
                        if (!scheduleSel.value) {
                            setError(
                                'ferry_schedule_id',
                                'Please select a schedule.',
                            );
                            hasErr = true;
                        } else {
                            setError('ferry_schedule_id');
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
                                'travel_date',
                                'Please choose a travel date.',
                            );
                            hasErr = true;
                        } else {
                            var today = new Date();
                            today.setHours(0, 0, 0, 0);
                            var scheduleOpt =
                                scheduleSel.options[scheduleSel.selectedIndex];
                            var allowed = scheduleOpt
                                ? (function () {
                                      try {
                                          return JSON.parse(
                                              scheduleOpt.getAttribute(
                                                  'data-days',
                                              ) || '[]',
                                          );
                                      } catch (e) {
                                          return [];
                                      }
                                  })()
                                : [];
                            var dName = dayName(d);
                            if (min && d < min) {
                                setError(
                                    'travel_date',
                                    'Date must be on/after ' +
                                        dateInput.min +
                                        '.',
                                );
                                hasErr = true;
                            } else if (max && d > max) {
                                setError(
                                    'travel_date',
                                    'Date must be on/before ' +
                                        dateInput.max +
                                        '.',
                                );
                                hasErr = true;
                            } else if (d < today) {
                                setError(
                                    'travel_date',
                                    'Date cannot be in the past.',
                                );
                                hasErr = true;
                            } else if (
                                allowed.length &&
                                allowed.indexOf(dName) === -1
                            ) {
                                setError(
                                    'travel_date',
                                    'Ferry does not operate on ' + dName + '.',
                                );
                                hasErr = true;
                            } else {
                                setError('travel_date');
                            }
                        }
                        // Passengers
                        var pax = parseInt(paxInput.value || '0', 10);
                        if (!pax || pax < 1) {
                            setError(
                                'num_passengers',
                                'Enter at least 1 passenger.',
                            );
                            hasErr = true;
                        } else if (pax > 10) {
                            setError(
                                'num_passengers',
                                'Maximum allowed is 10.',
                            );
                            hasErr = true;
                        } else {
                            setError('num_passengers');
                        }

                        disableSubmit(hasErr);
                        return !hasErr;
                    }

                    if (bookingSel) {
                        bookingSel.addEventListener('change', function () {
                            syncDateBounds();
                            validateRealtime();
                        });
                    }
                    if (scheduleSel) {
                        scheduleSel.addEventListener('change', function () {
                            validateRealtime();
                        });
                    }
                    if (dateInput) {
                        dateInput.addEventListener('input', function () {
                            filterSchedulesByDate();
                            validateRealtime();
                        });
                    }
                    if (paxInput) {
                        paxInput.addEventListener('input', validateRealtime);
                    }

                    syncDateBounds();
                    filterSchedulesByDate();
                    validateRealtime();
                    form.addEventListener('submit', function (e) {
                        if (!validateRealtime()) e.preventDefault();
                    });
                });
            </script>
        </div>
    </div>
@endsection
