@extends("layouts.app")

@section("content")
    <div class="container max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900">Create Beach Event</h1>
        <div class="card p-6 space-y-6">
            <form
                id="event_create_form"
                method="POST"
                action="{{ route("beach-events.store") }}"
                class="space-y-6"
                novalidate
            >
                @csrf
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Name
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    />
                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="name"
                    ></p>
                </div>
                <div>
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Description
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    ></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="event_type"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Type
                        </label>
                        <select
                            id="event_type"
                            name="event_type"
                            class="form-input"
                            required
                        >
                            <option value="">Select event type</option>
                            <option value="water_sports">Water Sports</option>
                            <option value="beach_volleyball">
                                Beach Volleyball
                            </option>
                            <option value="surfing">Surfing</option>
                            <option value="snorkeling">Snorkeling</option>
                            <option value="beach_party">Beach Party</option>
                            <option value="other">Other</option>
                        </select>
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="event_type"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="location"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Location
                        </label>
                        <input
                            id="location"
                            name="location"
                            type="text"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            for="event_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Date
                        </label>
                        <input
                            id="event_date"
                            name="event_date"
                            type="date"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="event_date"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="start_time"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Start Time
                        </label>
                        <input
                            id="start_time"
                            name="start_time"
                            type="time"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="start_time"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="end_time"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            End Time
                        </label>
                        <input
                            id="end_time"
                            name="end_time"
                            type="time"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="end_time"
                        ></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            for="capacity"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Capacity
                        </label>
                        <input
                            id="capacity"
                            name="capacity"
                            type="number"
                            min="1"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="capacity"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="price"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Price
                        </label>
                        <input
                            id="price"
                            name="price"
                            type="number"
                            step="0.01"
                            min="0"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="price"
                        ></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input
                            id="equipment_included"
                            name="equipment_included"
                            type="checkbox"
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                        />
                        <label
                            for="equipment_included"
                            class="text-sm text-gray-700"
                        >
                            Equipment Included
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="age_restriction"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Min Age (optional)
                        </label>
                        <input
                            id="age_restriction"
                            name="age_restriction"
                            type="number"
                            min="0"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
                </div>
                <div>
                    <x-primary-button type="submit">
                        {{ __("Create Event") }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('event_create_form');
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
                    function validate() {
                        var err = false;
                        var name = document.getElementById('name');
                        if (!name.value.trim()) {
                            setError('name', 'Please enter a name.');
                            err = true;
                        } else setError('name');
                        var type = document.getElementById('event_type');
                        if (!type.value) {
                            setError('event_type', 'Select a type.');
                            err = true;
                        } else setError('event_type');
                        var date = document.getElementById('event_date');
                        if (!date.value) {
                            setError('event_date', 'Choose a date.');
                            err = true;
                        } else {
                            var today = new Date();
                            today.setHours(0, 0, 0, 0);
                            var d = new Date(date.value);
                            if (d < today) {
                                setError(
                                    'event_date',
                                    'Date must be today or later.',
                                );
                                err = true;
                            } else setError('event_date');
                        }
                        var start = document.getElementById('start_time');
                        var end = document.getElementById('end_time');
                        if (!start.value) {
                            setError('start_time', 'Required.');
                            err = true;
                        } else setError('start_time');
                        if (!end.value) {
                            setError('end_time', 'Required.');
                            err = true;
                        } else if (
                            start.value &&
                            end.value &&
                            end.value <= start.value
                        ) {
                            setError('end_time', 'End must be after start.');
                            err = true;
                        } else setError('end_time');
                        var cap = document.getElementById('capacity');
                        if (!cap.value || parseInt(cap.value, 10) < 1) {
                            setError(
                                'capacity',
                                'Capacity must be at least 1.',
                            );
                            err = true;
                        } else setError('capacity');
                        var price = document.getElementById('price');
                        if (price.value === '' || parseFloat(price.value) < 0) {
                            setError('price', 'Enter non-negative price.');
                            err = true;
                        } else setError('price');
                        disableSubmit(err);
                        return !err;
                    }
                    [
                        'name',
                        'event_type',
                        'event_date',
                        'start_time',
                        'end_time',
                        'capacity',
                        'price',
                        'location',
                    ].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) el.addEventListener('input', validate);
                    });
                    validate();
                    form.addEventListener('submit', function (e) {
                        if (!validate()) e.preventDefault();
                    });
                });
            </script>
        </div>
    </div>
@endsection
