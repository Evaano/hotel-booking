@extends("layouts.app")

@section("content")
    @php($hotel = $hotel ?? null)
    <div class="max-w-3xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            Create Room
            @if ($hotel)
                <span class="text-gray-500 text-lg">— {{ $hotel->name }}</span>
            @endif
        </h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            <form
                id="room_create_form"
                method="POST"
                action="{{ route("hotels.rooms.store", $hotel) }}"
                class="space-y-4"
                novalidate
            >
                @csrf

                <div>
                    <label
                        for="room_number"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                    >
                        Room Number
                    </label>
                    <input
                        id="room_number"
                        name="room_number"
                        type="text"
                        required
                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    />
                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="room_number"
                    ></p>
                </div>
                <div>
                    <label
                        for="room_type"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                    >
                        Room Type
                    </label>
                    <select
                        id="room_type"
                        name="room_type"
                        required
                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    >
                        <option value="">Select room type</option>
                        @foreach(\App\Models\Room::getRoomTypes() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="room_type"
                    ></p>
                </div>
                <div>
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
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
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            for="max_occupancy"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        >
                            Max Occupancy
                        </label>
                        <input
                            id="max_occupancy"
                            name="max_occupancy"
                            type="number"
                            min="1"
                            max="10"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="max_occupancy"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="base_price"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        >
                            Base Price
                        </label>
                        <input
                            id="base_price"
                            name="base_price"
                            type="number"
                            step="0.01"
                            min="0"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="base_price"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                        >
                            Status
                        </label>
                        <select id="status" name="status" class="form-input">
                            <option value="">Select status</option>
                            <option value="available" selected>
                                Available
                            </option>
                            <option value="occupied">Occupied</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"
                    >
                        Amenities
                    </label>
                    @php($amenities = ["wifi" => "Wi-Fi", "ac" => "Air Conditioning", "tv" => "Television", "minibar" => "Mini Bar"])
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        @foreach ($amenities as $key => $label)
                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $key }}"
                                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <x-primary-button type="submit">
                        {{ __("Create Room") }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('room_create_form');
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
                        ['room_number', 'room_type'].forEach(function (id) {
                            var el = document.getElementById(id);
                            if (!el.value.trim()) {
                                setError(id, 'Required field.');
                                err = true;
                            } else setError(id);
                        });
                        var occ = document.getElementById('max_occupancy');
                        if (!occ.value || occ.value < 1 || occ.value > 10) {
                            setError('max_occupancy', 'Enter 1-10.');
                            err = true;
                        } else setError('max_occupancy');
                        var price = document.getElementById('base_price');
                        if (price.value === '' || parseFloat(price.value) < 0) {
                            setError(
                                'base_price',
                                'Enter a non-negative price.',
                            );
                            err = true;
                        } else setError('base_price');
                        disableSubmit(err);
                        return !err;
                    }
                    [
                        'room_number',
                        'room_type',
                        'max_occupancy',
                        'base_price',
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
