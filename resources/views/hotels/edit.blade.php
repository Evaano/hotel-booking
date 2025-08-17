@extends("layouts.app")

@section("content")
    <div class="container max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Hotel</h1>
        <div class="card p-6 space-y-6">
            @php($hotel = $hotel ?? null)
            <form
                id="hotel_edit_form"
                method="POST"
                action="{{ route("hotels.update", $hotel) }}"
                class="space-y-6"
                novalidate
            >
                @csrf
                @method("PUT")

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
                        value="{{ old("name", $hotel?->name) }}"
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
                        rows="4"
                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    >
{{ old("description", $hotel?->description) }}</textarea
                    >
                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="description"
                    ></p>
                </div>

                <div>
                    <label
                        for="address"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Address
                    </label>
                    <input
                        id="address"
                        name="address"
                        type="text"
                        value="{{ old("address", $hotel?->address) }}"
                        required
                        class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                    />
                    <p
                        class="mt-1 text-sm text-red-600 hidden"
                        data-error-for="address"
                    ></p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="latitude"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Latitude
                        </label>
                        <input
                            id="latitude"
                            name="latitude"
                            type="number"
                            step="0.000001"
                            value="{{ old("latitude", $hotel?->latitude) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="latitude"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="longitude"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Longitude
                        </label>
                        <input
                            id="longitude"
                            name="longitude"
                            type="number"
                            step="0.000001"
                            value="{{ old("longitude", $hotel?->longitude) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="longitude"
                        ></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Amenities
                    </label>
                    @php($amenities = ["pool" => "Pool", "spa" => "Spa", "restaurant" => "Restaurant", "gym" => "Gym", "beach_access" => "Beach Access"])
                    @php($existing = collect($hotel?->amenities ?? []))
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        @foreach ($amenities as $key => $label)
                            <label class="inline-flex items-center gap-2">
                                <input
                                    type="checkbox"
                                    name="amenities[]"
                                    value="{{ $key }}"
                                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                                    {{ $existing->contains(function ($val) { return is_string($val);}) && $existing->contains($label) ? "checked" : ($existing->contains($key) ? "checked" : "") }}
                                />
                                <span>{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            for="rating"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Rating
                        </label>
                        <input
                            id="rating"
                            name="rating"
                            type="number"
                            step="0.1"
                            min="0"
                            max="5"
                            value="{{ old("rating", $hotel?->rating) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="rating"
                        ></p>
                    </div>
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Status
                        </label>
                        <select id="status" name="status" class="form-input">
                            <option value="">Select status</option>
                            <option
                                value="active"
                                {{ old("status", $hotel?->status) == "active" ? "selected" : "" }}
                            >
                                Active
                            </option>
                            <option
                                value="inactive"
                                {{ old("status", $hotel?->status) == "inactive" ? "selected" : "" }}
                            >
                                Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div>
                    <x-primary-button type="submit">
                        {{ __("Save Changes") }}
                    </x-primary-button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById('hotel_edit_form');
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
                        var addr = document.getElementById('address');
                        if (!addr.value.trim()) {
                            setError('address', 'Please enter an address.');
                            err = true;
                        } else setError('address');
                        var lat = document.getElementById('latitude');
                        if (
                            lat.value !== '' &&
                            (parseFloat(lat.value) < -90 ||
                                parseFloat(lat.value) > 90)
                        ) {
                            setError(
                                'latitude',
                                'Latitude must be between -90 and 90.',
                            );
                            err = true;
                        } else setError('latitude');
                        var lng = document.getElementById('longitude');
                        if (
                            lng.value !== '' &&
                            (parseFloat(lng.value) < -180 ||
                                parseFloat(lng.value) > 180)
                        ) {
                            setError(
                                'longitude',
                                'Longitude must be between -180 and 180.',
                            );
                            err = true;
                        } else setError('longitude');
                        var rating = document.getElementById('rating');
                        if (
                            rating.value !== '' &&
                            (parseFloat(rating.value) < 0 ||
                                parseFloat(rating.value) > 5)
                        ) {
                            setError(
                                'rating',
                                'Rating must be between 0 and 5.',
                            );
                            err = true;
                        } else setError('rating');
                        disableSubmit(err);
                        return !err;
                    }
                    [
                        'name',
                        'address',
                        'latitude',
                        'longitude',
                        'rating',
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
