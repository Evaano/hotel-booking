@extends("layouts.app")

@section("content")
    @php($activity = $activity ?? null)
    <div class="container max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Activity</h1>
        <div class="card p-6 space-y-6">
            <div class="text-xs text-gray-500">ID: {{ $activity?->id }}</div>

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
                id="activity_edit_form"
                method="POST"
                action="{{ route("theme-park.update-activity", $activity) }}"
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
                        value="{{ old("name", $activity->name) }}"
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
                    >
{{ old("description", $activity->description) }}</textarea
                    >
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="category"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Category
                        </label>
                        <select
                            id="category"
                            name="category"
                            class="form-input"
                            required
                        >
                            <option value="">Select category</option>
                            <option
                                value="ride"
                                {{ old("category", $activity->category) == "ride" ? "selected" : "" }}
                            >
                                Ride
                            </option>
                            <option
                                value="show"
                                {{ old("category", $activity->category) == "show" ? "selected" : "" }}
                            >
                                Show
                            </option>
                            <option
                                value="experience"
                                {{ old("category", $activity->category) == "experience" ? "selected" : "" }}
                            >
                                Experience
                            </option>
                            <option
                                value="dining"
                                {{ old("category", $activity->category) == "dining" ? "selected" : "" }}
                            >
                                Dining
                            </option>
                            <option
                                value="shopping"
                                {{ old("category", $activity->category) == "shopping" ? "selected" : "" }}
                            >
                                Shopping
                            </option>
                        </select>
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="category"
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
                            value="{{ old("price", $activity->price) }}"
                            required
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                        <p
                            class="mt-1 text-sm text-red-600 hidden"
                            data-error-for="price"
                        ></p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label
                            for="capacity"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Capacity (optional)
                        </label>
                        <input
                            id="capacity"
                            name="capacity"
                            type="number"
                            min="1"
                            value="{{ old("capacity", $activity->capacity) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
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
                            value="{{ old("age_restriction", $activity->age_restriction) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
                    <div>
                        <label
                            for="height_restriction"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Min Height (cm)
                        </label>
                        <input
                            id="height_restriction"
                            name="height_restriction"
                            type="number"
                            min="0"
                            value="{{ old("height_restriction", $activity->height_restriction) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label
                            for="duration_minutes"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Duration (minutes)
                        </label>
                        <input
                            id="duration_minutes"
                            name="duration_minutes"
                            type="number"
                            min="1"
                            value="{{ old("duration_minutes", $activity->duration_minutes) }}"
                            class="w-full rounded-md border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                        />
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
                                {{ old("status", $activity->status) == "active" ? "selected" : "" }}
                            >
                                Active
                            </option>
                            <option
                                value="inactive"
                                {{ old("status", $activity->status) == "inactive" ? "selected" : "" }}
                            >
                                Inactive
                            </option>
                            <option
                                value="maintenance"
                                {{ old("status", $activity->status) == "maintenance" ? "selected" : "" }}
                            >
                                Maintenance
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
                    var form = document.getElementById('activity_edit_form');
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
                        var cat = document.getElementById('category');
                        if (!cat.value) {
                            setError('category', 'Please choose a category.');
                            err = true;
                        } else setError('category');
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
                        'category',
                        'price',
                        'capacity',
                        'age_restriction',
                        'height_restriction',
                        'duration_minutes',
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
