@extends("layouts.app")

@section("content")
    <div class="container max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">
            Create Ferry Schedule
        </h1>
        <div class="card p-6 space-y-6">
            <form
                id="schedule_create_form"
                method="POST"
                action="{{ route("ferry.store-schedule") }}"
                class="space-y-6"
                novalidate
            >
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label
                            for="departure_time"
                            value="Departure Time"
                        />
                        <x-text-input
                            id="departure_time"
                            name="departure_time"
                            type="time"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="departure_time"
                        ></p>
                    </div>
                    <div>
                        <x-input-label
                            for="arrival_time"
                            value="Arrival Time"
                        />
                        <x-text-input
                            id="arrival_time"
                            name="arrival_time"
                            type="time"
                            required
                        />
                        <p
                            class="form-error hidden"
                            data-error-for="arrival_time"
                        ></p>
                    </div>
                </div>
                <div>
                    <x-input-label for="route" value="Route" />
                    <x-text-input
                        id="route"
                        name="route"
                        type="text"
                        required
                        placeholder="Mainland ⇄ Island"
                    />
                    <p class="form-error hidden" data-error-for="route"></p>
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
                </div>
                <div>
                    <x-input-label value="Days of Week" />
                    @php($days = ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"])
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        @foreach ($days as $d)
                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    name="days_of_week[]"
                                    value="{{ $d }}"
                                    class="form-input"
                                />
                                <span class="capitalize">{{ $d }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p
                        class="form-error hidden"
                        data-error-for="days_of_week"
                    ></p>
                </div>
                <div>
                    <button type="submit" class="btn-primary">
                        Create Schedule
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('schedule_create_form');
                    var submitBtn = form.querySelector('button[type="submit"]');
                    function setError(name, msg) {
                        var el = document.querySelector(
                            '[data-error-for="' + name + '"]',
                        );
                        if (!el) return;
                        if (msg) {
                            el.textContent = msg;
                            el.classList.remove('hidden');
                        } else {
                            el.textContent = '';
                            el.classList.add('hidden');
                        }
                    }
                    function disableSubmit(dis) {
                        submitBtn.disabled = !!dis;
                        submitBtn.classList.toggle('opacity-50', !!dis);
                        submitBtn.classList.toggle('cursor-not-allowed', !!dis);
                    }
                    function validate() {
                        var err = false;
                        var dep = document.getElementById('departure_time');
                        var arr = document.getElementById('arrival_time');
                        if (!dep.value) {
                            setError('departure_time', 'Required.');
                            err = true;
                        } else setError('departure_time');
                        if (!arr.value) {
                            setError('arrival_time', 'Required.');
                            err = true;
                        } else if (
                            dep.value &&
                            arr.value &&
                            arr.value <= dep.value
                        ) {
                            setError(
                                'arrival_time',
                                'Arrival must be after departure.',
                            );
                            err = true;
                        } else setError('arrival_time');
                        var route = document.getElementById('route');
                        if (!route.value.trim()) {
                            setError('route', 'Required.');
                            err = true;
                        } else setError('route');
                        var cap = document.getElementById('capacity');
                        if (!cap.value || parseInt(cap.value, 10) < 1) {
                            setError('capacity', 'Enter capacity >= 1.');
                            err = true;
                        } else setError('capacity');
                        var price = document.getElementById('price');
                        if (price.value === '' || parseFloat(price.value) < 0) {
                            setError('price', 'Enter non-negative price.');
                            err = true;
                        } else setError('price');
                        var days = document.querySelectorAll(
                            'input[name="days_of_week[]"]:checked',
                        );
                        if (days.length === 0) {
                            setError(
                                'days_of_week',
                                'Select at least one day.',
                            );
                            err = true;
                        } else setError('days_of_week');
                        disableSubmit(err);
                        return !err;
                    }
                    [
                        'departure_time',
                        'arrival_time',
                        'route',
                        'capacity',
                        'price',
                    ].forEach(function (id) {
                        var el = document.getElementById(id);
                        if (el) el.addEventListener('input', validate);
                    });
                    Array.prototype.forEach.call(
                        document.querySelectorAll(
                            'input[name="days_of_week[]"]',
                        ),
                        function (cb) {
                            cb.addEventListener('change', validate);
                        },
                    );
                    validate();
                    form.addEventListener('submit', function (e) {
                        if (!validate()) e.preventDefault();
                    });
                });
            </script>
        </div>
    </div>
@endsection
