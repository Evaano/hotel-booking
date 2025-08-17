@extends("layouts.app")

@section("content")
    @php($event = $event ?? null)
    <div class="container max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">Edit Event</h1>
        <div class="card p-6 space-y-6">
            <div class="text-xs text-muted-500">ID: {{ $event?->id }}</div>

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
                id="event_edit_form"
                method="POST"
                action="{{ route("beach-events.update", $event) }}"
                class="space-y-6"
                novalidate
            >
                @csrf
                @method("PUT")
                <div>
                    <x-input-label for="name" value="Name" />
                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $event->name) }}"
                        required
                    />
                    <p class="form-error hidden" data-error-for="name"></p>
                </div>
                <div>
                    <x-input-label for="description" value="Description" />
                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        class="form-input"
                    >
{{ old("description", $event->description) }}</textarea
                    >
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="event_type"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Type
                        </label>
                        @php($eventTypeOptions = [
                            ["label" => "Water Sports", "value" => "water_sports"],
                            ["label" => "Beach Volleyball", "value" => "beach_volleyball"],
                            ["label" => "Surfing", "value" => "surfing"],
                            ["label" => "Snorkeling", "value" => "snorkeling"],
                            ["label" => "Beach Party", "value" => "beach_party"],
                            ["label" => "Other", "value" => "other"],
                        ])
                        <select
                            id="event_type"
                            name="event_type"
                            class="form-input"
                            required
                        >
                            <option value="">Select event type</option>
                            @foreach ($eventTypeOptions as $option)
                                <option
                                    value="{{ $option["value"] }}"
                                    {{ old("event_type", $event->event_type) === $option["value"] ? "selected" : "" }}
                                >
                                    {{ $option["label"] }}
                                </option>
                            @endforeach
                        </select>
                        <p
                            class="form-error hidden"
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
                            value="{{ old("location", $event->location) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="event_date" value="Date" />
                        <x-text-input
                            id="event_date"
                            name="event_date"
                            type="date"
                            value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="event_date"
                        ></p>
                    </div>
                    <div>
                        <x-input-label for="start_time" value="Start Time" />
                        <x-text-input
                            id="start_time"
                            name="start_time"
                            type="time"
                            value="{{ old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i')) }}"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="start_time"
                        ></p>
                    </div>
                    <div>
                        <x-input-label for="end_time" value="End Time" />
                        <x-text-input
                            id="end_time"
                            name="end_time"
                            type="time"
                            value="{{ old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i')) }}"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="end_time"
                        ></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label for="capacity" value="Capacity" />
                        <x-text-input
                            id="capacity"
                            name="capacity"
                            type="number"
                            min="1"
                            value="{{ old('capacity', $event->capacity) }}"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="capacity"
                        ></p>
                    </div>
                    <div>
                        <x-input-label for="price" value="Price" />
                        <x-text-input
                            id="price"
                            name="price"
                            type="number"
                            step="0.01"
                            min="0"
                            value="{{ old('price', $event->price) }}"
                            required
                        />
                        <p class="form-error hidden" data-error-for="price"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <input
                            id="equipment_included"
                            name="equipment_included"
                            type="checkbox"
                            class="form-input"
                            {{ old("equipment_included", $event->equipment_included) ? "checked" : "" }}
                        />
                        <label
                            for="equipment_included"
                            class="text-sm text-muted-700"
                        >
                            Equipment Included
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label
                            for="age_restriction"
                            value="Min Age (optional)"
                        />
                        <x-text-input
                            id="age_restriction"
                            name="age_restriction"
                            type="number"
                            min="0"
                            value="{{ old('age_restriction', $event->age_restriction) }}"
                        />
                    </div>
                    <div>
                        <x-input-label for="status" value="Status" />
                        @php($statusOptions = [
                            ["label" => "Active", "value" => "active"],
                            ["label" => "Cancelled", "value" => "cancelled"],
                            ["label" => "Completed", "value" => "completed"],
                        ])
                        <select id="status" name="status" class="form-input">
                            <option value="">Select status</option>
                            @foreach ($statusOptions as $option)
                                <option
                                    value="{{ $option["value"] }}"
                                    {{ old("status", $event->status) === $option["value"] ? "selected" : "" }}
                                >
                                    {{ $option["label"] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <button type="submit" class="btn-primary">
                        Save Changes
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('event_edit_form');
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
                        } else setError('event_date');
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
                        'status',
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
