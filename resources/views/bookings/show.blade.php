@extends("layouts.app")

@section("content")
    @php($entity = $booking ?? null)
    <div class="max-w-4xl mx-auto p-6 space-y-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            Booking Details
        </h1>
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            @php($attributes = $entity?->getAttributes() ?? [])
            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse ($attributes as $key => $value)
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst(str_replace("_", " ", $key)) }}
                        </dt>
                        <dd
                            class="col-span-2 text-sm text-gray-900 dark:text-gray-100"
                        >
                            {{ is_scalar($value) ? $value : json_encode($value) }}
                        </dd>
                    </div>
                @empty
                    <div class="text-gray-500 dark:text-gray-400">
                        No details
                    </div>
                @endforelse
            </dl>
        </div>

        @if (isset($booking))
            <div
                class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex items-center justify-between"
            >
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Status:
                    <span class="font-medium text-gray-900 dark:text-gray-100">
                        {{ ucfirst($booking->booking_status) }}
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    @if ($booking->booking_status !== "cancelled")
                        <form
                            method="POST"
                            action="{{ route("bookings.cancel", $booking) }}"
                            onsubmit="return confirm('Cancel this booking?');"
                        >
                            @csrf
                            <button type="submit" class="btn-error">
                                Cancel Booking
                            </button>
                        </form>
                    @endif

                    @if (auth()->check() && (auth()->user()->role === "hotel_operator" || auth()->user()->role === "admin"))
                        <form
                            method="POST"
                            action="{{ route("bookings.update-status", $booking) }}"
                            class="flex items-center gap-2"
                        >
                            @csrf
                            @method("PUT")
                            @php($booking_status_options = [
                                ["label" => "Pending", "value" => "pending"],
                                ["label" => "Confirmed", "value" => "confirmed"],
                                ["label" => "Completed", "value" => "completed"],
                                ["label" => "Cancelled", "value" => "cancelled"],
                            ])
                            <div>
                                <select
                                    id="booking_status"
                                    name="booking_status"
                                    class="form-input"
                                >
                                    @foreach ($booking_status_options as $option)
                                        <option
                                            value="{{ $option["value"] }}"
                                            {{ $booking->booking_status === $option["value"] ? "selected" : "" }}
                                        >
                                            {{ $option["label"] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @php($payment_status_options = [
                                ["label" => "Payment...", "value" => ""],
                                ["label" => "Pending", "value" => "pending"],
                                ["label" => "Paid", "value" => "paid"],
                                ["label" => "Refunded", "value" => "refunded"],
                            ])
                            <div>
                                <select
                                    id="payment_status"
                                    name="payment_status"
                                    class="form-input"
                                >
                                    @foreach ($payment_status_options as $option)
                                        <option
                                            value="{{ $option["value"] }}"
                                            {{ $booking->payment_status === $option["value"] ? "selected" : "" }}
                                        >
                                            {{ $option["label"] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn-primary">
                                Save
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
