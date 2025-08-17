@extends("layouts.app")

@section("content")
    @php($ticket = $ticket ?? null)
    <div class="container max-w-5xl mx-auto py-8 space-y-6">
        <h1 class="text-2xl font-semibold text-muted-900">Ticket Activities</h1>

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
                <p class="text-sm text-green-800">{{ session("success") }}</p>
            </div>
        @endif

        <div class="card p-6">
            <div class="text-sm text-muted-500">
                Ticket ID: {{ $ticket?->id ?? "—" }}
            </div>
            <ul class="mt-2 text-sm space-y-2">
                @forelse ($ticket->activityBookings ?? [] as $booking)
                    <li
                        class="flex items-center justify-between bg-muted-50/50 rounded-xl px-3 py-2"
                    >
                        <div class="text-muted-700">
                            {{ $booking->parkActivity->name ?? "—" }}
                            <span class="text-muted-500">
                                · {{ $booking->num_participants }} participants
                            </span>
                        </div>
                        @if (($booking->status ?? "") !== "cancelled")
                            <form
                                method="POST"
                                action="{{ route("theme-park.cancel-activity", $booking) }}"
                                onsubmit="return confirm('Cancel this activity booking?');"
                                class="inline"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="p-1 text-red-600 hover:text-red-800 transition-colors duration-200"
                                    title="Cancel Activity Booking"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </form>
                        @else
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600"
                            >
                                Cancelled
                            </span>
                        @endif
                    </li>
                @empty
                    <li class="text-muted-500">No activities booked</li>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
