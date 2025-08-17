@extends("layouts.app")

@section("content")
    @php($event = $event ?? null)
    <div class="container max-w-3xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">Book Event</h1>
        <div class="card p-6 space-y-6">
            <div class="text-lg font-medium">{{ $event?->name ?? "—" }}</div>
            <div class="text-sm text-muted-600">
                Available Spots:
                <span id="spots_left">{{ $availableSpots ?? 0 }}</span>
            </div>

            <form
                id="beach_event_booking_form"
                method="POST"
                action="{{ route("beach-events.store-booking", $event) }}"
                class="space-y-6"
                novalidate
            >
                @csrf
                <div>
                    <x-input-label
                        for="num_participants"
                        value="Number of Participants"
                    />
                    <x-text-input
                        type="number"
                        id="num_participants"
                        name="num_participants"
                        min="1"
                        max="{{ $availableSpots ?? 1 }}"
                        value="{{ old('num_participants', 1) }}"
                        required
                    />
                    <p
                        class="mt-1 text-xs text-muted-500"
                        id="participants_hint"
                    >
                        Up to {{ $availableSpots ?? 1 }} spots available.
                    </p>
                    <p
                        class="form-error hidden"
                        data-error-for="num_participants"
                    ></p>
                </div>
                <div>
                    <x-input-label
                        for="special_requirements"
                        value="Special Requirements (optional)"
                    />
                    <textarea
                        id="special_requirements"
                        name="special_requirements"
                        rows="3"
                        class="form-input"
                        placeholder="Anything we should know?"
                    ></textarea>
                    <p
                        class="form-error hidden"
                        data-error-for="special_requirements"
                    ></p>
                </div>
                <div>
                    <button type="submit" class="btn-primary">
                        Book Event
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var form = document.getElementById(
                        'beach_event_booking_form',
                    );
                    var numInput = document.getElementById('num_participants');
                    var submitBtn = form.querySelector('button[type="submit"]');
                    var maxSpots = parseInt(
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

                    function validateRealtime() {
                        var hasErr = false;
                        var val = parseInt(numInput.value || '0', 10);
                        if (!val || val < 1) {
                            setError(
                                'num_participants',
                                'Enter at least 1 participant.',
                            );
                            hasErr = true;
                        } else if (val > maxSpots) {
                            setError(
                                'num_participants',
                                'Maximum available is ' + maxSpots + '.',
                            );
                            hasErr = true;
                        } else {
                            setError('num_participants');
                        }
                        disableSubmit(hasErr);
                        return !hasErr;
                    }

                    if (numInput) {
                        numInput.addEventListener('input', validateRealtime);
                    }
                    validateRealtime();
                    form.addEventListener('submit', function (e) {
                        if (!validateRealtime()) e.preventDefault();
                    });
                });
            </script>
        </div>
    </div>
@endsection
