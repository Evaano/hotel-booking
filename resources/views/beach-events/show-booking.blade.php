@extends("layouts.app")

@section("content")
    @php($booking = $booking ?? null)
    <div class="container max-w-4xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">Booking Details</h1>
        <div class="card p-6">
            @php($attributes = $booking?->getAttributes() ?? [])
            <dl class="divide-y divide-muted-200/50">
                @forelse ($attributes as $key => $value)
                    <div class="grid grid-cols-3 gap-4 py-2">
                        <dt class="text-sm text-muted-500">
                            {{ ucfirst(str_replace("_", " ", $key)) }}
                        </dt>
                        <dd class="col-span-2 text-sm text-muted-900">
                            {{ is_scalar($value) ? $value : json_encode($value) }}
                        </dd>
                    </div>
                @empty
                    <div class="text-muted-500">No details</div>
                @endforelse
            </dl>
        </div>

        @if (isset($booking))
            <div class="card p-6 flex items-center justify-between">
                <div class="text-sm text-muted-600">
                    Status:
                    <span class="font-medium text-muted-900">
                        {{ ucfirst($booking->booking_status) }}
                    </span>
                </div>
                <div>
                    @if ($booking->booking_status !== "cancelled")
                        <form
                            method="POST"
                            action="{{ route("beach-events.cancel-booking", $booking) }}"
                            onsubmit="return confirm('Cancel this event booking?');"
                        >
                            @csrf
                            <button type="submit" class="btn-secondary">
                                Cancel Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
