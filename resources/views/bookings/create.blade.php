@extends("layouts.app")

@section("content")
    @php($hotel = $hotel ?? null)
    @php($room = $room ?? null)
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            Create Booking
        </h1>

        @if (session("success"))
            <div
                class="p-4 bg-green-100 border border-green-400 text-green-700 rounded-md"
            >
                {{ session("success") }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-6">
            @if ($hotel)
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-blue-900">
                        Hotel: {{ $hotel->name }}
                    </h3>
                </div>
            @endif

            @if ($room)
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-green-900">
                        Room: #{{ $room->room_number }} —
                        {{ $room->room_type }}
                    </h3>
                </div>
            @endif

            <form
                id="booking_form"
                method="POST"
                action="{{ route("bookings.store") }}"
                class="space-y-6"
                novalidate
            >
                @csrf

                {{-- Room selection --}}

                @if ($room)
                    <input
                        type="hidden"
                        name="room_id"
                        value="{{ $room->id }}"
                    />
                @else
                    <div>
                        <label
                            for="room_id"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Select Room
                            <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="room_id"
                            id="room_id"
                            required
                            class="form-input"
                        >
                            <option value="">Choose an available room</option>
                            @foreach ($availableRooms ?? [] as $optRoom)
                                <option
                                    value="{{ $optRoom->id }}"
                                    data-max-occupancy="{{ $optRoom->max_occupancy }}"
                                    {{ old("room_id") == $optRoom->id ? "selected" : "" }}
                                >
                                    #{{ $optRoom->room_number }} —
                                    {{ $optRoom->room_type }} (max
                                    {{ $optRoom->max_occupancy }})
                                </option>
                            @endforeach
                        </select>

                        @error("room_id")
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="room_id"
                        ></p>
                        <p class="text-xs text-gray-500 mt-1">
                            💡 Tip: Open a hotel page and click "Book this room"
                            for a one-click preselect.
                        </p>
                    </div>
                @endif

                {{-- Date selection --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label
                            for="check_in_date"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Check-in Date
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="check_in_date"
                            id="check_in_date"
                            value="{{ old("check_in_date") }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        @error("check_in_date")
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="check_in_date"
                        ></p>
                    </div>

                    <div>
                        <label
                            for="check_out_date"
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Check-out Date
                            <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="date"
                            name="check_out_date"
                            id="check_out_date"
                            value="{{ old("check_out_date") }}"
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        @error("check_out_date")
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="check_out_date"
                        ></p>
                    </div>
                </div>

                {{-- Number of guests --}}
                <div>
                    <label
                        for="num_guests"
                        class="block text-sm font-medium text-gray-700 mb-2"
                    >
                        Number of Guests
                        <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        name="num_guests"
                        id="num_guests"
                        value="{{ old("num_guests", 1) }}"
                        min="1"
                        @if($room) max="{{ $room->max_occupancy }}" @endif
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                    @error("num_guests")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="num_guests"
                    ></p>
                    <p class="mt-1 text-xs text-gray-500" id="guests_hint">
                        @if ($room)
                            Up to {{ $room->max_occupancy }} guests for this
                            room.
                        @else
                                Select a room to see the maximum allowed guests.
                        @endif
                    </p>
                </div>

                {{-- Submit button --}}
                <div class="pt-4">
                    <button
                        type="submit"
                        id="submit_btn"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 font-medium transition-colors"
                    >
                        Create Booking
                    </button>
                </div>
            </form>

            {{-- Real-time validation script --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const roomSelect = document.getElementById('room_id');
                    const guestsInput = document.getElementById('num_guests');
                    const hint = document.getElementById('guests_hint');
                    const form = document.getElementById('booking_form');
                    const submitBtn = document.getElementById('submit_btn');

                    function setError(fieldId, message) {
                        const errorEl = document.querySelector(
                            '[data-error-for="' + fieldId + '"]',
                        );
                        const inputEl = document.getElementById(fieldId);
                        if (!errorEl) return;

                        if (message) {
                            errorEl.textContent = message;
                            errorEl.classList.remove('hidden');
                            if (inputEl) {
                                inputEl.classList.add(
                                    'border-red-500',
                                    'ring-red-500',
                                );
                                inputEl.classList.remove('border-gray-300');
                            }
                        } else {
                            errorEl.textContent = '';
                            errorEl.classList.add('hidden');
                            if (inputEl) {
                                inputEl.classList.remove(
                                    'border-red-500',
                                    'ring-red-500',
                                );
                                inputEl.classList.add('border-gray-300');
                            }
                        }
                    }

                    function syncGuestsMax() {
                        if (!roomSelect) return;
                        const selected =
                            roomSelect.options[roomSelect.selectedIndex];
                        const max = selected
                            ? selected.getAttribute('data-max-occupancy')
                            : null;

                        if (max) {
                            guestsInput.setAttribute('max', max);
                            if (hint) {
                                hint.textContent =
                                    'Up to ' +
                                    max +
                                    ' guests for selected room.';
                            }
                        } else {
                            guestsInput.removeAttribute('max');
                            if (hint) {
                                hint.textContent =
                                    'Select a room to see the maximum allowed guests.';
                            }
                        }
                    }

                    function parseDate(value) {
                        const d = new Date(value);
                        return isNaN(d.getTime()) ? null : d;
                    }

                    function toggleSubmitDisabled(disabled) {
                        if (!submitBtn) return;
                        submitBtn.disabled = !!disabled;
                        if (disabled) {
                            submitBtn.classList.add(
                                'opacity-50',
                                'cursor-not-allowed',
                            );
                            submitBtn.classList.remove('hover:bg-blue-700');
                        } else {
                            submitBtn.classList.remove(
                                'opacity-50',
                                'cursor-not-allowed',
                            );
                            submitBtn.classList.add('hover:bg-blue-700');
                        }
                    }

                    function validateRealtime() {
                        let hasError = false;

                        // Room validation
                        if (roomSelect && !roomSelect.value) {
                            setError('room_id', 'Please select a room.');
                            hasError = true;
                        } else {
                            setError('room_id');
                        }

                        // Date validation
                        const inEl = document.getElementById('check_in_date');
                        const outEl = document.getElementById('check_out_date');
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        const inDate = parseDate(inEl.value);
                        const outDate = parseDate(outEl.value);

                        if (!inDate) {
                            setError(
                                'check_in_date',
                                'Please select a check-in date.',
                            );
                            hasError = true;
                        } else if (inDate < today) {
                            setError(
                                'check_in_date',
                                'Check-in must be today or later.',
                            );
                            hasError = true;
                        } else {
                            setError('check_in_date');
                        }

                        if (!outDate) {
                            setError(
                                'check_out_date',
                                'Please select a check-out date.',
                            );
                            hasError = true;
                        } else if (inDate && outDate <= inDate) {
                            setError(
                                'check_out_date',
                                'Check-out must be after check-in.',
                            );
                            hasError = true;
                        } else {
                            setError('check_out_date');
                        }

                        // Guests validation
                        const maxAttr = guestsInput.getAttribute('max');
                        const maxGuests = maxAttr
                            ? parseInt(maxAttr, 10)
                            : null;
                        const guests = parseInt(guestsInput.value || '0', 10);

                        if (!guests || guests < 1) {
                            setError(
                                'num_guests',
                                'Please enter at least 1 guest.',
                            );
                            hasError = true;
                        } else if (maxGuests && guests > maxGuests) {
                            setError(
                                'num_guests',
                                'Maximum allowed is ' + maxGuests + '.',
                            );
                            hasError = true;
                        } else {
                            setError('num_guests');
                        }

                        toggleSubmitDisabled(hasError);
                        return !hasError;
                    }

                    // Event listeners
                    if (roomSelect) {
                        roomSelect.addEventListener('change', function () {
                            syncGuestsMax();
                            validateRealtime();
                        });
                        syncGuestsMax();
                    }

                    ['check_in_date', 'check_out_date', 'num_guests'].forEach(
                        function (id) {
                            const el = document.getElementById(id);
                            if (el) {
                                el.addEventListener('input', validateRealtime);
                                el.addEventListener('change', validateRealtime);
                            }
                        },
                    );

                    if (form) {
                        form.addEventListener('submit', function (e) {
                            if (!validateRealtime()) {
                                e.preventDefault();
                            }
                        });
                    }

                    // Initial validation
                    validateRealtime();
                });
            </script>
        </div>
    </div>
@endsection
